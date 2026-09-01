param(
    [Parameter(Mandatory=$true)][string]$Project,
    [string]$Php,
    [string]$Email
)

Write-Host "[versi ps1: 2 - PHP auto-detect]"

if ([string]::IsNullOrWhiteSpace($Php)) {
    $candidates = @("C:\xampp\php\php.exe")
    $Php = $null
    foreach ($c in $candidates) {
        if (Test-Path -LiteralPath $c) { $Php = $c; break }
    }
    if (-not $Php) {
        $cmd = Get-Command php -ErrorAction SilentlyContinue
        if ($cmd) { $Php = $cmd.Source }
    }
    if (-not $Php) {
        Write-Host "[X] PHP tidak ditemukan. Berikan -Php <path>."
        exit 1
    }
}
Write-Host "Menggunakan PHP: $Php"
Write-Host "Email notifikasi: $Email"

$php    = $Php
$spark  = Join-Path $Project 'spark'
$log    = Join-Path $Project 'writable\logs\attendance_download.log'

if ($Email -ne '') {
    $actionArg = '"' + $php + '" "' + $spark + '" attendance:download email=' + $Email
} else {
    $actionArg = '"' + $php + '" "' + $spark + '" attendance:download'
}
$actionArg += ' >> "' + $log + '" 2>&1'

Import-Module ScheduledTasks -ErrorAction SilentlyContinue

$specs = @(
    @{ Name = 'HRMS Attendance 08:15'; Time = '08:15' },
    @{ Name = 'HRMS Attendance 20:30'; Time = '20:30' }
)

foreach ($s in $specs) {
    $action  = New-ScheduledTaskAction -Execute 'cmd.exe' -Argument $actionArg -WorkingDirectory $Project
    $trigger = New-ScheduledTaskTrigger -Daily -At $s.Time
    $settings = New-ScheduledTaskSettingsSet -StartWhenAvailable -MultipleInstances IgnoreNew

    try {
        $principal = New-ScheduledTaskPrincipal -UserId 'SYSTEM' -LogonType ServiceAccount -RunLevel Highest
        Register-ScheduledTask -TaskName $s.Name -Action $action -Trigger $trigger -Principal $principal -Settings $settings -Force -ErrorAction Stop | Out-Null
        Write-Host "[OK] $($s.Name) dibuat (SYSTEM)"
    } catch {
        Write-Host "[i] SYSTEM ditolak untuk $($s.Name): $($_.Exception.Message)"
        try {
            $principal2 = New-ScheduledTaskPrincipal -UserId $env:USERNAME -LogonType Interactive -RunLevel Highest
            Register-ScheduledTask -TaskName $s.Name -Action $action -Trigger $trigger -Principal $principal2 -Settings $settings -Force -ErrorAction Stop | Out-Null
            Write-Host "[OK] $($s.Name) dibuat sebagai $env:USERNAME"
        } catch {
            Write-Host "[X] Gagal membuat $($s.Name): $($_.Exception.Message)"
        }
    }
}

Write-Host ""
Write-Host "=================== VERIFIKASI ==================="
Get-ScheduledTask -TaskName 'HRMS Attendance 08:15', 'HRMS Attendance 20:30' -ErrorAction SilentlyContinue |
    Format-Table TaskName, State, @{n='Execute';e={$_.Actions.Execute}}, @{n='Args';e={$_.Actions.Arguments}}, @{n='Start';e={$_.Triggers.StartBoundary}} -AutoSize