@echo off

rem -------------------------------------------------------------
rem  _ command line
rem -------------------------------------------------------------

@setlocal

set _PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%_PATH%_\Console.php" %*

@endlocal