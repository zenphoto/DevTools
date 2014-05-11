@ECHO OFF
SET VERSION=%1
SET BETAREL=%2
IF NOT [%VERSION%] == [] GOTO SKIPVERSION
	echo Usage: tag VERSION_NUMBER REL
  echo Where REL is the release tag, e.g. Beta, RC1, etc. or empty for a primary release.
  GOTO END
:SKIPVERSION
SET REL=%VERSION%
IF [%BETAREL%]==[] GOTO TAG
SET REL=%VERSION%-%2
SET VERSION=%VERSION% %2
:TAG
FINDSTR "ZENPHOTO_VERSION" zp-core\version.php 
SET /P ANSWER=Is the version number set to %REL%? (Y/N)?
if /i {%ANSWER%}=={y} (goto :YES)
if /i {%ANSWER%}=={yes} (goto :YES)
GOTO END
:YES
@ECHO ON
echo "Tagging %VERSION% (REL=%REL%)..."
call git_head
git push
git tag -a -f -m"Zenphoto version %VERSION%" zenphoto-%REL%
git push --tags
:END