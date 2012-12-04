@ECHO OFF
SET VERSION=%1
SET BETAREL=%2
IF NOT [%VERSION%] == [] GOTO SKIPVERSION
	echo Usage: tag.sh VERSION_NUMBER BETA
  echo Where BETA is true if the release is beta, empty if not.
  GOTO END
:SKIPVERSION
SET REL=%VERSION%
IF [%BETAREL%]==[] GOTO TAG
SET REL=%VERSION%Beta
SET VERSION=%VERSION% Beta
:TAG
echo "Tagging %VERSION% (REL=%REL%)..."
@ECHO ON
git tag -a -m"Zenphoto version %VERSION%" Zenphoto-%REL%
git push --tags
:END