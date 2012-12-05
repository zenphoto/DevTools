@echo off
git rev-parse HEAD>zp-core\githead
SET /P LONG=<zp-core\githead
SET SHORT=%LONG:~0,10%
git add zp-core\githead
git commit -m"release id %SHORT%"
