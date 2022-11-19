@echo off

set port=88

echo extension_dir = "%cd%\php\ext" >> php\php.ini
echo .
echo      Buka http://localhost:%port% di browser
echo      Atau http://127.0.0.1:%port% di browser
echo .

php\php.exe data\artisan serve --port %port%