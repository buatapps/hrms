@echo off
setlocal
title HRMS Attendance Task - Setup

REM ============================================================
REM  Buat 2 task jadwal otomatis download absensi (08:15 & 20:30)
REM  Setiap task mengeksekusi "run-attendance.cmd" (wrapper) yang
REM  berisi perintah php + redirect log. menghindari escaping /TR.
REM  Wajib dijalankan sebagai Administrator.
REM ============================================================

net session >nul 2>&1
if not "%errorlevel%"=="0" (
    echo Meminta izin Administrator...
    powershell -NoProfile -Command "Start-Process -FilePath '%~f0' -Verb RunAs"
    exit /b
)

echo [versi batch: 3 - schtasks + wrapper cmd]

set "PROJECT=%~dp0"
for %%I in ("%PROJECT%.") do set "SPROJECT=%%~sI\"
if "%SPROJECT%"=="" set "SPROJECT=%PROJECT%"

if not exist "%PROJECT%spark" (
    echo [ERROR] File 'spark' tidak ditemukan di: %PROJECT%
    pause
    exit /b 1
)

if not exist "%PROJECT%writable\logs" mkdir "%PROJECT%writable\logs"

REM Alamat email notifikasi
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

REM Deteksi PHP
set "PHP=C:\xampp\php\php.exe"
if not exist "%PHP%" (
    set "PHP="
    for /f "delims=" %%i in ('where php 2^>nul') do set "PHP=%%i"
)
if "%PHP%"=="" (
    echo [ERROR] PHP tidak ditemukan.
    pause
    exit /b 1
)

REM Tulis wrapper run-attendance.cmd (mengandung redirect log)
if not "%EMAIL%"=="" (
    >"%PROJECT%run-attendance.cmd" echo @echo off
    >>"%PROJECT%run-attendance.cmd" echo "%PHP%" "%PROJECT%spark" attendance:download email=%EMAIL% ^>^> "%PROJECT%writable\logs\attendance_download.log" 2^>^&1
) else (
    >"%PROJECT%run-attendance.cmd" echo @echo off
    >>"%PROJECT%run-attendance.cmd" echo "%PHP%" "%PROJECT%spark" attendance:download ^>^> "%PROJECT%writable\logs\attendance_download.log" 2^>^&1
)

echo.
echo Menggunakan PHP: %PHP%
echo Email notifikasi: %EMAIL%
echo Wrapper: %SPROJECT%run-attendance.cmd
echo.

echo Membuat task jadwal otomatis download absensi...
schtasks /Create /TN "HRMS Attendance 08:15" /SC DAILY /ST 08:15 /RU SYSTEM /F /TR "\"%SPROJECT%run-attendance.cmd\""
if errorlevel 1 (
    echo [i] SYSTEM ditolak untuk 08:15, coba user %USERNAME% ...
    schtasks /Create /TN "HRMS Attendance 08:15" /SC DAILY /ST 08:15 /RU "%USERNAME%" /RL HIGHEST /F /TR "\"%SPROJECT%run-attendance.cmd\""
)
if errorlevel 1 ( echo [X] Gagal task 08:15 ) else ( echo [OK] task 08:15 )

schtasks /Create /TN "HRMS Attendance 20:30" /SC DAILY /ST 20:30 /RU SYSTEM /F /TR "\"%SPROJECT%run-attendance.cmd\""
if errorlevel 1 (
    echo [i] SYSTEM ditolak untuk 20:30, coba user %USERNAME% ...
    schtasks /Create /TN "HRMS Attendance 20:30" /SC DAILY /ST 20:30 /RU "%USERNAME%" /RL HIGHEST /F /TR "\"%SPROJECT%run-attendance.cmd\""
)
if errorlevel 1 ( echo [X] Gagal task 20:30 ) else ( echo [OK] task 20:30 )

echo.
echo ================== VERIFIKASI ==================
schtasks /Query /TN "HRMS Attendance 08:15" /FO LIST
echo.
schtasks /Query /TN "HRMS Attendance 20:30" /FO LIST

echo.
set /p RUNTEST=Jalankan sekarang untuk tes? (Y/N): 
if /i not "%RUNTEST%"=="Y" goto done

echo.
echo Menjalankan task 'HRMS Attendance 08:15' ...
schtasks /Run /TN "HRMS Attendance 08:15"
echo Menunggu 30 detik, lalu lihat log...
timeout /t 30 /nobreak >nul
echo.
echo ================== ISI LOG ==================
if exist "%PROJECT%writable\logs\attendance_download.log" (
    type "%PROJECT%writable\logs\attendance_download.log"
) else (
    echo Log belum terbentuk.
)

:done
echo.
echo ===== SELESAI =====
pause
exit /b 0