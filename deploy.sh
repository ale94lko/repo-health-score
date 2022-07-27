#!/usr/bin/env sh
# abort on errors
set -e

echo "::group::Push changes"
git init

git config user.email 'github-action[bot]@noreply.github.com'
git config user.name 'github-actions[bot]'

git add -A
git commit -m 'deploy'

git push -f "https://$GITHUB_ACTOR:$GITHUB_TOKEN@github.com/$GITHUB_REPOSITORY.git" main:output
echo "::endgroup::"