@echo off
setlocal
title Install FFmpeg (HRMS)
echo ============================================
echo   Install FFmpeg untuk HRMS Digiman
echo   Cara pakai: klik 2x file ini
echo   (jika gagal: klik kanan ^> Run as administrator)
echo ============================================

powershell -NoProfile -ExecutionPolicy Bypass -File "%~dp0install_ffmpeg.ps1"
set RC=%errorlevel%

echo.
if %RC%==0 (
    echo [OK] FFmpeg selesai dipasang.
) else (
    echo [GAGAL] Instalasi tidak selesai (kode %RC%). 
    echo         Periksa koneksi internet / coba "Run as administrator".
)
echo.
pause