@ECHO OFF
SET VERSION=%1
SET BETAREL=%2
IF NOT [%VERSION%] == [] GOTO SKIPVERSION
SET /p VERSION= Enter the Zenphoto version:
:SKIPVERSION
SET REL=%VERSION%
IF NOT [%BETAREL%]==[] GOTO ISBETA
CHOICE /C yn /M "Is this a beta tag?
IF %ERRORLEVEL% == 2 GOTO TAG
:ISBETA
SET REL=%VERSION%Beta
echo v:%REL%
SET VERSION=%VERSION% Beta
:TAG
echo verson:%VERSION%
echo REL:%REL%
@ECHO ON
git tag -a -m"Zenphoto version %VERSION%" Zenphoto-%REL%
git push --tags
