#!/usr/bin/env bash

set -e
set -x

sh runCodeSniffer.sh
# sh runPhpStan.sh
# sh runPhpUnit.sh
# sh runBehat.sh

php test/check_site.php
