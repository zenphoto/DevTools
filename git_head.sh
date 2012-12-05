#!/usr/bin/env bash
# No need to remove old file if we use overwrite (single >)
git rev-parse HEAD > zp-core/githead
SHORT="$(git rev-parse --short HEAD)"
git add zp-core/githead
git commit -m "release id ${SHORT}"