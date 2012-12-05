@echo off
git rev-parse HEAD>zp-core\githead
FOR /F "tokens=*" %%i in ('git rev-parse --short HEAD') do SET SHORT=%%i 
git add zp-core\githead
git commit -m"release id %SHORT%"