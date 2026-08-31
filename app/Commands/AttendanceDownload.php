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
        $machines = $machineModel->findAll();
        $success = 0;
        $failed = 0;

        foreach ($machines as $machine) {
            $result = $this->downloadMachine($machine, $attendanceModel);
            $name = $machine->name ?? $machine->ip;

            if ($result['success']) {
                $success++;
                CLI::write("{$name}: {$result['message']}", 'green');
            } else {
                $failed++;
                CLI::write("{$name}: {$result['message']}", 'red');
            }
        }

        CLI::write("Completed. Success: {$success}, Failed: {$failed}");
    }

    private function downloadMachine($machine, AttendanceModel $attendanceModel): array
    {
        $connect = @fsockopen($machine->ip, 80, $errno, $errstr, 1);

        if (!$connect) {
            return ['success' => false, 'message' => "Connection failed ({$errstr})"];
        }

        $request = '<GetAttLog><ArgComKey xsi:type="xsd:integer">'
            . $machine->key
            . '</ArgComKey><Arg><PIN xsi:type="xsd:integer">All</PIN></Arg></GetAttLog>';
        $newLine = "\r\n";

        fwrite($connect, 'POST /iWsService HTTP/1.0' . $newLine);
        fwrite($connect, 'Content-Type: text/xml' . $newLine);
        fwrite($connect, 'Content-Length: ' . strlen($request) . $newLine . $newLine);
        fwrite($connect, $request . $newLine);

        $buffer = '';
        while ($response = fgets($connect, 2048)) {
            $buffer .= $response;
        }
        fclose($connect);

        if ($buffer === '') {
            return ['success' => false, 'message' => 'Empty response'];
        }

        $buffer = $this->parseData($buffer, '<GetAttLogResponse>', '</GetAttLogResponse>');
        $inserted = 0;

        foreach (explode("\r\n", $buffer) as $row) {
            $data = $this->parseData($row, '<Row>', '</Row>');
            $pin = $this->parseData($data, '<PIN>', '</PIN>');
            $dateTime = $this->parseData($data, '<DateTime>', '</DateTime>');
            $verified = $this->parseData($data, '<Verified>', '</Verified>');
            $status = $this->parseData($data, '<Status>', '</Status>');

            if (!$pin || !$dateTime || $attendanceModel->checkData($machine->id, $pin, $dateTime, $verified, $status) != 0) {
                continue;
            }

            $parts = explode(' ', $dateTime);
            if (count($parts) < 2) {
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

        return ['success' => true, 'message' => "Success ({$inserted} data)"];
    }

    private function parseData(string $data, string $start, string $end): string
    {
        $startPosition = strpos($data, $start);
        if ($startPosition === false) {
            return '';
        }

        $startPosition += strlen($start);
        $endPosition = strpos($data, $end, $startPosition);

        return $endPosition === false ? '' : substr($data, $startPosition, $endPosition - $startPosition);
    }
}
