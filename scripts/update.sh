#!/bin/sh

cd /var/home/phpopendocs/PHPOpenDocs

git fetch

UPSTREAM=${1:-'@{u}'}
LOCAL=$(git rev-parse @)
REMOTE=$(git rev-parse "$UPSTREAM")
BASE=$(git merge-base @ "$UPSTREAM")

# put current date as yyyy-mm-dd HH:MM:SS in $date
printf -v date '%(%Y-%m-%d %H:%M:%S)T\n' -1

if [ $LOCAL = $REMOTE ]; then
    echo "Up-to-date ${date}"
elif [ $LOCAL = $BASE ]; then
    echo "Need to pull ${date}"
    git pull
    chown -R deployer:deployer *
    sh runProd.sh
elif [ $REMOTE = $BASE ]; then
    echo "Need to push"
else
    echo "Diverged"
fi