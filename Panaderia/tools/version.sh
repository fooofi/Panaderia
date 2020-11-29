#!/usr/bin/env bash

PACKAGE_VERSION=$(cat package.json | grep version | head -1 | awk -F: '{ print $2 }' | sed 's/[\",]//g' | tr -d '[[:space:]]')
BUILD_VERSION=3
IFS='.'
read -ra ADDR <<<"$PACKAGE_VERSION" #reading str as an array as tokens separated by IFS
BUILD_VERSION=$(( ADDR[0] * 10000 + ADDR[1] * 100 + ADDR[2]))

echo "$PACKAGE_VERSION" > VERSION
