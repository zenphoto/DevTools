@echo off
git rev-parse HEAD>zp-core\githead
git add zp-core\githead
git commit -m"release id"