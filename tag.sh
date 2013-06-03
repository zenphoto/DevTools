#!/usr/bin/env bash
VERSION=$1
BETAREL=$2
if [[ -z "$VERSION" || -z "$BETAREL" ]]
then
  echo "Usage: tag.sh VERSION_NUMBER BETA"
  echo "Where BETA is true if the release is beta, false if not."
  exit 1
fi
if [ "$BETAREL" = "true" ]
then
  REL=$VERSION"Beta"
else
  REL=$VERSION
fi
echo "Did you remember to set the version to %VERSION%?"
select yn in "Yes" "No"; do
    case $yn in
        Yes ) make install; break;;
        No ) exit;;
    esac
done
echo "Tagging $VERSION (REL=$REL)..."
git tag -a -m "Zenphoto version %VERSION%" zenphoto-$REL
tag.shgit push --tags