@echo off
setlocal
set /p EMAIL=<C:\xampp\htdocs\hrms\writable\notif_email.cfg
C:\xampp\php\php.exe C:\xampp\htdocs\hrms\spark attendance:download --email %EMAIL%
endlocal
