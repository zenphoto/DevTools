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
SET /P ANSWER=Is the version number set to %REL%? (Y/N)?
if /i {%ANSWER%}=={y} (goto :YES)
if /i {%ANSWER%}=={yes} (goto :YES)
GOTO END
:YES
@ECHO ON
echo "Tagging %VERSION% (REL=%REL%)..."
git tag -a -m"Zenphoto version %VERSION%" zenphoto-%REL%
git push --tags
:END