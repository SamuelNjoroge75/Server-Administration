#!/bin/bash
# push.sh - stage, commit and push all changes
REPO_DIR="$HOME/Server-Administration"
MSG="${1:-Auto update $(date '+%Y-%m-%d %H:%M:%S')}"

cd "$REPO_DIR" || exit 1
git pull --rebase origin main
git add -A

if git diff --cached --quiet; then
    echo "No changes to commit."
    exit 0
fi

git commit -m "$MSG"
git push origin main && echo "Pushed: $MSG"
