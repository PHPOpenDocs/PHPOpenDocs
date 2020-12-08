#!/usr/bin/env bash

set -e

php phpstan.phar analyze -c ./phpstan.neon -l 6 src