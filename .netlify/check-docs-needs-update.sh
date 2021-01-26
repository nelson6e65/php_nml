#!/usr/bin/env bash

git diff --quiet HEAD^ HEAD phpdoc.dist.xml

if [[ $? -eq 1 ]] ; then
    echo 'Changes in PHPDoc configuration file'
    exit 1
fi

git diff --quiet HEAD^ HEAD package-lock.json

if [[ $? -eq 1 ]] ; then
    echo 'Changes in npm dependencies'
    exit 1
fi

git diff --quiet HEAD^ HEAD docs

if [[ $? -ne 0 ]] ; then
    echo 'Changes in documentation files'
    exit 1
fi

git diff --quiet HEAD^ HEAD src

if [[ $? -ne 0 ]] ; then
    echo 'Changes in sources'
    exit 1
fi


echo 'There is not changes related with documentation'
