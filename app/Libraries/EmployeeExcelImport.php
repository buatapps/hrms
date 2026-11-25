<?php

namespace App\Libraries;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Throwable;

class EmployeeExcelImport
{
    public const MAX_ROWS = 1000;

    private const HEADER_MAP = [
        'id'                              => 'id',
        'company'                         => 'company_id',
        'name'                            => 'name',
        'employee id'                     => 'employee_id',
        'employee pin'                    => 'employee_pin',
        'division'                        => 'division_id',
        'position'                        => 'position_id',
        'plant'                           => 'plant_id',
        'group'                           => 'employee_group_id',
        'product synch'                   => 'product_synchronization',
        'date of entry'                   => 'date_of_entry',
        'year of service'                 => null,
        'employee status'                 => null,
        'working days'                    => 'working_days',
        'bank'                            => 'bank_id',
        'account number'                  => 'account_number',
        'salary'                          => 'salary',
        'npwp'                            => 'npwp_number',
        'tax status'                      => 'tax_status_id',
        'bpjs ketenagakerjaan'            => 'ketenagakerjaan_number',
        'bpjs kesehatan'                  => 'kesehatan_number',
        'clinic provider'                 => 'clinic_provider',
        'hospital provider'               => 'hospital_provider',
        'insurance employee'              => 'insurance_employee',
        'insurance husband / wife'        => 'insurance_couple',
        'insurance children'              => 'insurance_children',
        'uniform size'                    => 'uniform_size',
        'shoes size'                      => 'shoes_size',
        'gender'                          => 'gender_id',
        'place of birth'                  => 'place_of_birth',
        'date of birth'                   => 'date_of_birth',
        'age'                             => null,
        'blood type'                      => 'blood_type',
        'address'                         => 'address',
        'phone number'                    => 'phone_number',
        'email'                           => 'email',
        'identity number (ktp)'           => 'identity_number',
        'identity family number (kk)'     => 'identity_family_number',
        'religion'                        => 'religion',
        'education'                       => 'education_id',
        'marriage status'                 => 'marriage_status_id',
        'mothers name'                    => 'mothers_name',
        'number of children'              => 'number_of_children',
        'address (ktp)'                   => 'address_identity',
        'rt'                              => 'rt',
        'rw'                              => 'rw',
        'provinces'                       => 'provinces_id',
        'regencies'                       => 'regencies_id',
        'districts'                       => 'districts_id',
        'villages'                        => 'villages_id',
        'husband / wife name'             => 'couple',
        'husband / wife date of birth'    => 'couple_date_of_birth',
        '1st child name'                  => 'child_1',
        '1st child birthday'              => 'child_1_birthday',
        '1st child gender'                => 'child_1_gender',
        '2nd child name'                  => 'child_2',
        '2nd child birthday'              => 'child_2_birthday',
        '2nd child gender'                => 'child_2_gender',
        '3rd child name'                  => 'child_3',
        '3rd child birthday'              => 'child_3_birthday',
        '3rd child gender'                => 'child_3_gender',
        'emregency calling name'          => 'emergency_name',
        'relathionship'                   => 'emergency_relathionship',
        'contact number'                  => 'emergency_contact',
    ];

    private const DATE_FIELDS = [
        'date_of_entry',
        'date_of_birth',
        'couple_date_of_birth',
        'child_1_birthday',
        'child_2_birthday',
        'child_3_birthday',
    ];

    private const NUMERIC_FIELDS = [
        'employee_pin',
        'working_days',
        'salary',
        'number_of_children',
    ];

    private const LOOKUP_FIELDS = [
        'company_id',
        'division_id',
        'position_id',
        'plant_id',
        'employee_group_id',
        'bank_id',
        'tax_status_id',
        'gender_id',
        'education_id',
        'marriage_status_id',
        'provinces_id',
        'regencies_id',
        'districts_id',
        'villages_id',
    ];

    private array $lookups;

    public function __construct(array $lookups = [])
    {
        $this->lookups = $lookups;
    }

    public static function headers(): array
    {
        return array_keys(self::HEADER_MAP);
    }

    public function parse(string $filePath): array
    {
        $result = [
            'rows'            => [],
            'errors'          => [],
            'ignored_headers' => [],
        ];

        try {
            $spreadsheet = IOFactory::load($filePath);
        } catch (Throwable $e) {
            $result['errors'][] = [
                'row'     => 0,
                'message' => 'File Excel tidak dapat dibaca.',
            ];

            return $result;
        }

        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $lastColumn = Coordinate::columnIndexFromString($sheet->getHighestColumn());

        if ($highestRow - 1 > self::MAX_ROWS) {
            $result['errors'][] = [
                'row'     => 0,
                'message' => 'Jumlah baris melebihi batas ' . self::MAX_ROWS . '.',
            ];

            return $result;
        }

        $columns = [];
        $idColumn = null;

        for ($col = 1; $col <= $lastColumn; $col++) {
            $header = $this->normalizeHeader($sheet->getCell([$col, 1])->getValue());

            if ($header === '' || !array_key_exists($header, self::HEADER_MAP)) {
                if ($header !== '') {
                    $result['ignored_headers'][] = $header;
                }
                continue;
            }

            $field = self::HEADER_MAP[$header];

            if ($field === null) {
                $result['ignored_headers'][] = $header;
                continue;
            }

            $columns[$col] = $field;

            if ($field === 'id') {
                $idColumn = $col;
            }
        }

        if ($idColumn === null) {
            $result['errors'][] = [
                'row'     => 1,
                'message' => 'Header ID wajib ada.',
            ];

            return $result;
        }

        for ($rowNumber = 2; $rowNumber <= $highestRow; $rowNumber++) {
            $values = [];
            $hasData = false;

            foreach ($columns as $col => $field) {
                $raw = $sheet->getCell([$col, $rowNumber])->getValue();

                if ($this->isBlank($raw)) {
                    continue;
                }

                $hasData = true;
                $value = $this->normalizeValue($field, $raw, $rowNumber, $result['errors']);

                if ($value !== null) {
                    $values[$field] = $value;
                }
            }

            if (!$hasData) {
                continue;
            }

            $id = $values['id'] ?? null;

            if (!is_int($id) || $id <= 0) {
                $result['errors'][] = [
                    'row'     => $rowNumber,
                    'message' => 'ID harus berupa angka positif.',
                ];
                continue;
            }

            unset($values['id']);

            if ($values === []) {
                continue;
            }

            $result['rows'][] = [
                'row'  => $rowNumber,
                'id'   => $id,
                'data' => $values,
            ];
        }

        return $result;
    }

    private function normalizeHeader($value): string
    {
        $value = preg_replace('/[\r\n\t]+/', ' ', (string) $value);
        return preg_replace('/\s+/', ' ', strtolower(trim($value)));
    }

    private function isBlank($value): bool
    {
        return $value === null || trim((string) $value) === '';
    }

    private function normalizeValue(string $field, $raw, int $rowNumber, array &$errors)
    {
        $text = ltrim(trim((string) $raw), "'");

        if (in_array($field, self::LOOKUP_FIELDS, true)) {
            $key = preg_replace('/\s+/', ' ', strtolower($text));

            if (!isset($this->lookups[$field][$key])) {
                $errors[] = [
                    'row'     => $rowNumber,
                    'message' => 'Nilai "' . $text . '" tidak dikenal untuk ' . $field . '.',
                ];

                return null;
            }

            return $this->lookups[$field][$key];
        }

        if (in_array($field, self::DATE_FIELDS, true)) {
            $timestamp = is_numeric($raw)
                ? ExcelDate::excelToTimestamp((float) $raw)
                : strtotime($text);

            if ($timestamp === false) {
                $errors[] = [
                    'row'     => $rowNumber,
                    'message' => 'Format tanggal tidak valid untuk ' . $field . '.',
                ];

                return null;
            }

            return date('Y-m-d', $timestamp);
        }

        if (in_array($field, self::NUMERIC_FIELDS, true)) {
            if (!is_numeric($text)) {
                $errors[] = [
                    'row'     => $rowNumber,
                    'message' => 'Nilai ' . $field . ' harus berupa angka.',
                ];

                return null;
            }

            return $text + 0;
        }

        if ($field === 'id') {
            return filter_var($text, FILTER_VALIDATE_INT);
        }

        return $text;
    }
}
