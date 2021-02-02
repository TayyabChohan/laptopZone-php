@ECHO OFF
REM CONVERT THE FILE PATH TO PROJECT ROOT FOLDER I.E D:\wamp\www\laptopzone

REM To COMMENT A LINE, put "REM" before them:
set map=%~dp0
call:get_parent_path "%map%"
REM echo full_path is %_full_path%
call:get_parent_path %_full_path%
REM echo full_path is %_full_path%
call:get_parent_path %_full_path%
REM echo full_path is %_full_path%
call:get_last_path %_full_path%
REM echo last_path is %_last_path%

goto :eof

:get_parent_path
set "_full_path=%~dp1"
:_strip
if not "%_full_path:~-1%"=="\" if not "%_full_path:~-1%"=="/" goto:_strip_end
set "_full_path=%_full_path:~0,-1%"
goto:_strip
:_strip_end
exit /b

:get_last_path
set "_last_path=%~nx1"
echo full_path is %_full_path%

REM END CONVERT THE FILE PATH TO PROJECT ROOT FOLDER I.E D:\wamp\www\laptopzone

title GetEpid 
%~d0 REM GIVE DIRECTORY ALPHABET I.E D:
cd %_full_path%

	:STEP1

	php index.php cron_job c_cron_job GetEpid 3

IF ERRORLEVEL 1 GOTO :RETRY

	:RETRY

	php index.php cron_job c_cron_job GetEpid 3
IF ERRORLEVEL 1 GOTO :STEP1

PAUSE
