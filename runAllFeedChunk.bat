@echo off

pushd D:\wamp\www\laptopzone\liveRssFeed\feedChunk
for /f "delims=" %%x in ('dir /b /a-d *.bat') do start "" "%%x"&timeout /t 5 >nul
popd