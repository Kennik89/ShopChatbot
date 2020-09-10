#!/bin/bash
DIR=${PWD##*/}

if [ "$DIR" != laradock ]
then
  cd laradock || { echo "Directory not found!"; exit 1; }
fi

docker-compose exec --user=laradock workspace bash
