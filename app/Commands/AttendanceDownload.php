<?php

namespace App\Commands;

use App\Models\AttendanceMachineModel;
use App\Models\AttendanceModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AttendanceDownload extends BaseCommand
{
    protected $group = 'Attendance';
    protected $name = 'attendance:download';
    protected $description = 'Download attendance logs from all attendance machines.';

    public function run(array $params)
    {
        set_time_limit(0);

        $machineModel = new AttendanceMachineModel();
        $attendanceModel = new AttendanceModel();

        $machines = $machineModel->where('deleted_at', null)->findAll();
        $details = [];
        $success = 0;
        $failed = 0;
        $totalInserted = 0;

        foreach ($machines as $machine) {
            $result = $this->downloadMachine($machine, $attendanceModel);
            $name = $machine->name ?? $machine->ip;

            if ($result['success']) {
                $success++;
                $totalInserted += $result['inserted'] ?? 0;
                CLI::write("{$name}: {$result['message']}", 'green');
            } else {
                $failed++;
                CLI::write("{$name}: {$result['message']}", 'red');
            }

            $details[] = [
                'name'    => $name,
                'success' => $result['success'],
                'message' => $result['message'],
            ];
        }

        CLI::write("Completed. Success: {$success}, Failed: {$failed}");

        $params['email'] = $this->resolveTargetEmail($params['email'] ?? null);
        if ($params['email']) {
            $this->sendNotification($details, $success, $failed, $totalInserted, $params['email']);
        }
    }

    private function resolveTargetEmail(?string $email): string
    {
        if (!empty($email)) {
            return $email;
        }

        $envEmail = env('app.notificationEmail');
        if (!empty($envEmail)) {
            return $envEmail;
        }

        return '';
    }

    private function sendNotification(array $details, int $success, int $failed, int $totalInserted, string $to): void
    {
        $emailService = \Config\Services::email();

        $rowsHtml = '';
        foreach ($details as $d) {
            $color   = $d['success'] ? '#28a745' : '#dc3545';
            $icon    = $d['success'] ? 'OK' : 'GAGAL';
            $rowsHtml .= "<tr>
                <td style='padding:8px;border:1px solid #ddd;'>{$d['name']}</td>
                <td style='padding:8px;border:1px solid #ddd;color:{$color};font-weight:bold;'>{$icon}</td>
                <td style='padding:8px;border:1px solid #ddd;'>{$d['message']}</td>
            </tr>";
        }

        $subject = "Attendance Download " . date('Y-m-d H:i') . " - Sukses {$success}/" . ($success + $failed);

        $message = "<h3>Laporan Download Absensi Otomatis</h3>
            <p>Waktu: <strong>" . date('Y-m-d H:i:s') . "</strong></p>
            <p>Total data baru tersimpan: <strong>{$totalInserted}</strong></p>
            <table style='border-collapse:collapse;width:100%;font-family:Arial,sans-serif;font-size:14px;'>
                <thead>
                    <tr style='background:#f2f2f2;'>
                        <th style='padding:8px;border:1px solid #ddd;text-align:left;'>Mesin</th>
                        <th style='padding:8px;border:1px solid #ddd;text-align:left;'>Status</th>
                        <th style='padding:8px;border:1px solid #ddd;text-align:left;'>Detail</th>
                    </tr>
                </thead>
                <tbody>{$rowsHtml}</tbody>
            </table>
            <br>
            <p>Terima kasih.</p>";

        $emailService->setTo($to);
        $emailService->setSubject($subject);
        $emailService->setMessage($message);

        if ($emailService->send()) {
            CLI::write("Notification email sent to {$to}", 'green');
        } else {
            CLI::write('Notification email FAILED: ' . $emailService->printDebugger(['headers']), 'red');
        }
    }

    private function downloadMachine($machine, AttendanceModel $attendanceModel): array
    {
        try {
            $connect = @fsockopen($machine->ip, 80, $errno, $errstr, 1);

            if (!$connect) {
                return ['success' => false, 'message' => "Connection failed ({$errstr})", 'inserted' => 0];
            }

            $request = '<GetAttLog><ArgComKey xsi:type="xsd:integer">'
                . htmlspecialchars($machine->key, ENT_XML1)
                . '</ArgComKey><Arg><PIN xsi:type="xsd:integer">All</PIN></Arg></GetAttLog>';
            $newLine = "\r\n";

            fwrite($connect, 'POST /iWsService HTTP/1.0' . $newLine);
            fwrite($connect, 'Content-Type: text/xml' . $newLine);
            fwrite($connect, 'Content-Length: ' . strlen($request) . $newLine . $newLine);
            fwrite($connect, $request . $newLine);

            stream_set_timeout($connect, 10);

            $buffer = '';
            while (!feof($connect)) {
                $response = fgets($connect, 2048);
                if ($response === false) {
                    break;
                }
                $buffer .= $response;
            }

            $meta = stream_get_meta_data($connect);
            fclose($connect);

            if ($buffer === '') {
                return ['success' => false, 'message' => 'Empty response', 'inserted' => 0];
            }

            if (!empty($meta['timed_out'])) {
                return ['success' => false, 'message' => 'Response timed out', 'inserted' => 0];
            }

            $rows = $this->parseRows($buffer);

            if ($rows === null) {
                return ['success' => false, 'message' => 'Failed to parse XML response', 'inserted' => 0];
            }

            $inserted = 0;

            foreach ($rows as $data) {
                $pin = (string)($data->PIN ?? '');
                $dateTime = (string)($data->DateTime ?? '');
                if ($pin === '' || $dateTime === '') {
                    continue;
                }

                $verified = (string)($data->Verified ?? '0');
                $status = (string)($data->Status ?? '0');

                if ($attendanceModel->checkData($machine->id, $pin, $dateTime, $verified, $status) != 0) {
                    continue;
                }

                $parts = explode(' ', trim($dateTime));
                if (count($parts) < 2 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $parts[0])) {
                    continue;
                }

                $attendanceModel->save([
                    'attendance_machine_id' => $machine->id,
                    'pin' => $pin,
                    'datetime' => $dateTime,
                    'date' => $parts[0],
                    'time' => $parts[1],
                    'verified' => $verified,
                    'status' => $status,
                ]);
                $inserted++;
            }

            return ['success' => true, 'message' => "Success ({$inserted} data)", 'inserted' => $inserted];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => "Error: {$e->getMessage()}", 'inserted' => 0];
        }
    }

    private function parseRows(string $buffer): ?array
    {
        $startPos = strpos($buffer, '<GetAttLogResponse>');
        $endPos = strpos($buffer, '</GetAttLogResponse>');

        if ($startPos === false || $endPos === false || $endPos <= $startPos) {
            return null;
        }

        $xml = substr($buffer, $startPos, $endPos - $startPos + strlen('</GetAttLogResponse>'));
        $xml = '<?xml version="1.0"?>' . $xml;

        $previous = libxml_use_internal_errors(true);
        $parsed = simplexml_load_string($xml);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if ($parsed === false) {
            return null;
        }

        $rows = [];
        foreach ($parsed->Row as $row) {
            $rows[] = $row;
        }

        return $rows;
    }
}
