#!/bin/bash

git pull

git add -A

git commit -m "`date +%Y-%m-%d_%H:%M:%S`"

git push
