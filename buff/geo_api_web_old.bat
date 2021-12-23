@echo off
start chrome.exe "http://120.51.223.55/haisya/haisya_info/geo_sql.php"
start chrome.exe "http://120.51.223.55/haisya/haisya_info/geo_sql_imp.php"

echo %ERRORLEVEL% 位置情報マスタ更新しました。
echo %ERRORLEVEL% 位置情報マスタ更新しました。 %date:/=%%time:~0,2%%time:~3,2%%time:~6,2% >> E:\HTTPRoot\log.txt 

timeout /t 3000 > nul

taskkill /IM chrome.exe /F

call E:\HTTPRoot\haisya\haisya_info\geo_api_web.bat