@echo off
setlocal
cd /d C:\xampp\htdocs\hrms
set /p EMAIL=<C:\xampp\htdocs\hrms\writable\notif_email.cfg
C:\xampp\php\php.exe C:\xampp\htdocs\hrms\spark attendance:download --email %EMAIL%
endlocal
