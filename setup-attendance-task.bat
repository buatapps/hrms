@echo off
setlocal
title HRMS Attendance Task - Setup

REM ============================================================
REM  SCRIPT DUA MODE
REM  1. Double-click  => instal 2 jadwal otomatis (08:15 & 20:30)
REM  2. Dijalankan Task Scheduler dengan argumen "run"
REM     => lakukan download absensi + simpan hasil ke log
REM ============================================================

REM --------------- MODE RUN (dipanggil Task Scheduler) ----------
if /i "%~1"=="run" goto :run

REM --------------- MODE INSTALL (double-click) ------------------

REM Minta izin administrator bila belum elevated
net session >nul 2>&1
if not "%errorlevel%"=="0" (
    echo Meminta izin administrator...
    powershell -NoProfile -Command "Start-Process -FilePath '%~f0' -Verb RunAs"
    exit /b
)

set "PROJECT=%~dp0"
for %%I in ("%PROJECT%.") do set "SPROJECT=%%~sI\"
if "%SPROJECT%"=="" set "SPROJECT=%PROJECT%"
echo [versi batch: 2 - shortpath fallback aktif]

REM Pastikan folder log ada
if not exist "%PROJECT%writable\logs" mkdir "%PROJECT%writable\logs"

REM Alamat email notifikasi (opsional). Kali pertama selalu ditanyakan.
if exist "%PROJECT%writable\notif_email.cfg" (
    set /p EMAIL=<"%PROJECT%writable\notif_email.cfg"
) else (
    set "EMAIL="
)

if "%EMAIL%"=="" (
    echo.
    echo ===== Konfigurasi Email Notifikasi =====
    echo Email kosong = tidak mengirim notifikasi.
    set /p EMAIL=Alamat email penerima notifikasi ^(contoh: nama@perusahaan.com^): 
)

echo %EMAIL%>"%PROJECT%writable\notif_email.cfg"

echo.
echo Membuat task jadwal otomatis download absensi...
echo.

REM Jalur PHP diserahkan ke ps1 (auto-detect). Diteruskan apa adanya.
powershell -NoProfile -ExecutionPolicy Bypass -File "%PROJECT%create-hrms-tasks.ps1" -Project "%PROJECT%" -Php "%PHP%" -Email "%EMAIL%"

echo.
set /p RUNTEST=Jalankan sekarang untuk tes? (Y/N): 
if /i not "%RUNTEST%"=="Y" goto :done

echo.
echo Menjalankan task 'HRMS Attendance 08:15' ...
schtasks /Run /TN "HRMS Attendance 08:15"
echo Menunggu 30 detik biar proses selesai, lalu lihat log...
timeout /t 30 /nobreak >nul

echo.
echo ================== ISI LOG ==================
if exist "%PROJECT%writable\logs\attendance_download.log" (
    type "%PROJECT%writable\logs\attendance_download.log"
) else (
    echo Log belum terbentuk. Kemungkinan PHP tidak ditemukan saat task berjalan.
)
goto :done

REM --------------- MODE RUN: eksekusi otomatis ------------------
:run
set "PROJECT=%~dp0"
for %%I in ("%PROJECT%.") do set "SPROJECT=%%~sI\"
if "%SPROJECT%"=="" set "SPROJECT=%PROJECT%"

REM Deteksi PHP: pakai XAMPP bila ada, kalau tidak cek PATH
set "PHP=C:\xampp\php\php.exe"
if exist "%PHP%" goto :php_ok
set "PHP="
for /f "delims=" %%i in ('where php 2^>nul') do (
    set "PHP=%%i"
    goto :php_ok
)

if not exist "%PROJECT%writable\logs" mkdir "%PROJECT%writable\logs"
echo %date% %time% - ERROR: PHP tidak ditemukan >> "%PROJECT%writable\logs\attendance_download.log"
exit /b 1

:php_ok
if not exist "%PROJECT%writable\logs" mkdir "%PROJECT%writable\logs"
echo ===== %date% %time% - mulai download ===== >> "%PROJECT%writable\logs\attendance_download.log"
set "EMAIL="
if exist "%PROJECT%writable\notif_email.cfg" (
    set /p EMAIL=<"%PROJECT%writable\notif_email.cfg"
)
if not "%EMAIL%"=="" set "EMAIL=email=%EMAIL%"
"%PHP%" "%SPROJECT%spark" attendance:download %EMAIL% >> "%PROJECT%writable\logs\attendance_download.log" 2>&1
exit /b %errorlevel%

:done
echo.
echo ===== SELESAI =====
pause
exit /b 0