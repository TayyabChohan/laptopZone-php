@ECHO
D:
cd D:/wamp/www/laptopzone
 :STEP1 
 php index.php cron_job c_cron_job runLocalStreamChunk 10000001064 10000001164
 IF ERRORLEVEL 1 GOTO :RETRY 
 
 :RETRY 
 php index.php cron_job c_cron_job runLocalStreamChunk 10000001064 10000001164 
 IF ERRORLEVEL 1 GOTO :STEP1 
 PAUSE