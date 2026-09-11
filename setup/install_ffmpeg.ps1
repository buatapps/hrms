# ============================================================
# Install FFmpeg untuk HRMS Digiman
# Diunduh dari gyan.dev dan dipasang ke C:\ffmpeg\bin
# Jalankan via: install_ffmpeg.bat (klik 2x)
# ============================================================

[CmdletBinding()]
param(
    [switch]$Force   # paksa unduh & pasang ulang walaupun sudah ada
)

$ErrorActionPreference = 'Stop'
$targetExe = 'C:\ffmpeg\bin\ffmpeg.exe'

function Write-Step {
    param([string]$msg)
    Write-Host "`n==> $msg" -ForegroundColor Cyan
}

try {
    # 1. Cek apakah FFmpeg sudah terpasang
    if (-not $Force -and (Test-Path -LiteralPath $targetExe)) {
        Write-Host "FFmpeg sudah terpasang di: $targetExe" -ForegroundColor Yellow
        & $targetExe -version 2>$null | Select-Object -First 1
        Write-Host "`nTidak ada yang perlu dilakukan. (Gunakan 'Force' untuk pasang ulang.)" -ForegroundColor Yellow
        exit 0
    }

    # 2. Unduh (aktifkan TLS 1.2 untuk PowerShell lama)
    Write-Step "Mengunduh FFmpeg (~100 MB) ... ini bisa memakan beberapa menit."
    [Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
    $zip = Join-Path $env:TEMP 'ffmpeg-essentials-setup.zip'
    if (Test-Path -LiteralPath $zip) { Remove-Item -Force $zip }
    $wc = New-Object System.Net.WebClient
    $wc.DownloadFile('https://www.gyan.dev/ffmpeg/builds/ffmpeg-release-essentials.zip', $zip)
    if (-not (Test-Path -LiteralPath $zip)) { throw 'Gagal mengunduh FFmpeg.' }

    # 3. Ekstrak
    Write-Step 'Mengekstrak arsip...'
    $dest = Join-Path $env:TEMP ('ffmpeg_setup_' + [guid]::NewGuid().ToString('N'))
    Expand-Archive -LiteralPath $zip -DestinationPath $dest -Force

    # 4. Pasang ke C:\ffmpeg\bin
    Write-Step 'Memasang ke C:\ffmpeg\bin...'
    $bin = 'C:\ffmpeg\bin'
    try {
        New-Item -ItemType Directory -Force -Path $bin | Out-Null
    }
    catch {
        throw "Tidak bisa membuat folder '$bin'. Coba jalankan file .bat dengan klik kanan > 'Run as administrator'."
    }

    $found = Get-ChildItem -Path $dest -Recurse -Filter ffmpeg.exe | Select-Object -First 1
    if (-not $found) { throw 'ffmpeg.exe tidak ditemukan setelah ekstrak.' }
    Copy-Item -Path $found.FullName -Destination $bin -Force

    $probe = Get-ChildItem -Path $dest -Recurse -Filter ffprobe.exe | Select-Object -First 1
    if ($probe) { Copy-Item -Path $probe.FullName -Destination $bin -Force }

    # 5. Verifikasi
    Write-Step 'Verifikasi instalasi...'
    $ver = & $targetExe -version 2>&1 | Select-Object -First 1
    if (-not (Test-Path -LiteralPath $targetExe) -or -not $ver) { throw 'Instalasi gagal / ffmpeg tidak jalan.' }
    Write-Host "  $ver" -ForegroundColor White

    # 6. Tambahkan C:\ffmpeg\bin ke PATH user (agar perintah 'ffmpeg' dikenali)
    $userPath = [Environment]::GetEnvironmentVariable('Path', 'User')
    if ($userPath -notlike '*C:\ffmpeg\bin*') {
        [Environment]::SetEnvironmentVariable('Path', ($userPath.TrimEnd(';') + ';C:\ffmpeg\bin'), 'User')
        Write-Host "  Path C:\ffmpeg\bin ditambahkan ke PATH user (buka terminal baru)." -ForegroundColor Yellow
    }

    # 7. Bersihkan file sementara
    Remove-Item -Recurse -Force $dest -ErrorAction SilentlyContinue
    Remove-Item -Force $zip -ErrorAction SilentlyContinue

    Write-Host "`n[OK] FFmpeg siap digunakan oleh HRMS Digiman." -ForegroundColor Green
    Write-Host "    Sekarang video >8 MB yang di-upload lewat menu Digiman akan otomatis dikompres."
    exit 0
}
catch {
    Write-Host "`n[ERROR] $_" -ForegroundColor Red
    exit 1
}