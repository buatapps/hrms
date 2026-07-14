<?php
require __DIR__ . '/../app/Config/Database.php';

$db = \Config\Database::connect();
$tables = $db->listTables();
sort($tables);
echo "=== TABLES ===\n";
foreach ($tables as $t) {
    echo "  $t\n";
}

$interesting = ['users', 'users_details', 'auth_groups', 'auth_groups_users', 'employee', 'division', 'data_employee', 'employee_details'];
foreach ($interesting as $table) {
    if (in_array($table, $tables)) {
        echo "\n=== $table ===\n";
        $fields = $db->getFieldData($table);
        if (!empty($fields)) {
            foreach ($fields as $f) {
                echo "  {$f->name} ({$f->type}" . (!empty($f->max_length) ? ",{$f->max_length}" : '') . ")" . ($f->nullable ? " NULL" : " NOT NULL") . "\n";
            }
        } else {
            echo "  (no field data)\n";
        }
    }
}
