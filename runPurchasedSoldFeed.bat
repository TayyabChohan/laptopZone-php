@ECHO

D:
cd D:\wamp64\www\laptopzone
:Step1
php index.php cron_job c_cron_job runPurchasedSoldFeed 
IF ERRORLEVEL 1 GOTO :RETRY

:RETRY
php index.php cron_job c_cron_job runPurchasedSoldFeed 
IF ERRORLEVEL 1 GOTO :Step1


PAUSE



