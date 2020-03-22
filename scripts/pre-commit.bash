#!/usr/bin/env bash

echo "Running pre-commit hook"
./scripts/run-tests.bash

# $? stores exit value of the last command
if [ $? -ne 1 ]; then
 echo "TEST IS OK!"
 exit 0
else
 echo "TEST IK KO¡"
 exit 1
fi
