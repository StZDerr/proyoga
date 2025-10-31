@echo off
cd /d "C:\path\to\your\proyoga"
php artisan queue:work --sleep=3 --tries=3 --max-time=3600
pause