# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Modul Digiman (Digital Informasi Namicoh)

Papan informasi digital: menampilkan jam WIB realtime (bebas zona waktu device),
jadwal istirahat, dan slideshow video di TV/papan display.

File terkait:

- `app/Controllers/Digiman.php` — controller (upload video, jadwal istirahat)
- `app/Views/digiman/index.php` — halaman admin (kelola video & istirahat)
- `app/Views/digiman/board.php` — halaman display TV
- `assets/video/.htaccess` — streaming video (HTTP Range / 206)
- `digiman.sql` — tabel `jam_istirahat` & `digiman_video`

### Instalasi FFmpeg (WAJIB untuk video besar mulus di TV)

Video baru yang di-upload lewat menu Digiman otomatis dikompres ke **H.264
profile main, level 4.0, maks 1920x1080, `+faststart`**, audio AAC 96k —
format paling kompatibel dengan browser bawaan TV. Pakai FFmpeg (auto-detect).

Cara termudah (klik 2x):

```bat
setup\install_ffmpeg.bat
```

Script mengunduh FFmpeg dan memasang ke `C:\ffmpeg\bin\ffmpeg.exe`,
lalu menambahkan `C:\ffmpeg\bin` ke PATH user (efektif di terminal baru —
buka jendela PowerShell/CMD baru agar perintah `ffmpeg` dikenali).
Jika folder `C:\ffmpeg` tidak bisa dibuat, jalankan `.bat` sebagai
Administrator (klik kanan > Run as administrator).

Dipasang manual: cukup letakkan `ffmpeg.exe` di salah satu path yang
dikenali controller (`app/Controllers/Digiman.php` → `findFFmpeg()`):

- `C:\ffmpeg\bin\ffmpeg.exe`
- `C:\xampp\ffmpeg\bin\ffmpeg.exe`
- atau tersedia di `PATH` (env `FFMPEG_PATH`)

Tanpa FFmpeg, aplikasi tetap berjalan — video besar hanya disimpan apa
adanya dan berisiko lag/patah saat diputar di TV.

### Catatan

- Video MP4 kecil (<= 8 MB) dilewati kompresi agar upload cepat.
- Video lama yang di-upload **sebelum** FFmpeg terpasang tidak terkompres;
  upload ulang lewat menu Digiman agar diproses.
- Streaming video membutuhkan `mod_headers` Apache (aktif di XAMPP default).

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
