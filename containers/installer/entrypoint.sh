
set -e
set -x


ENV_TO_USE=${ENV_DESCRIPTION:=default}

echo "ENV_TO_USE is ${ENV_TO_USE}";

if [ "/var/app/composer.json" -nt "/var/app/composer.lock" ]
then
  printf '%s\n' "composer.json is newer than composer.lock"

  COMPOSER_TYPE=$(php src/check_composer_command.php)
  echo "composer type is ${COMPOSER_TYPE}";
  if [ "${COMPOSER_TYPE}" = "update" ]; then
      php composer.phar update --no-plugins
  else
      php composer.phar install
  fi
else
    printf '%s\n' "composer.json is not newer than composer.lock. Skipping install"
fi

# Generate config settings used per environment
php vendor/bin/classconfig \
  -p config.source.php \
  "PhpOpenDocs\\Config" \
  config.generated.php \
  $ENV_TO_USE

# php cli.php misc:wait_for_db
# php vendor/bin/phinx migrate -e internal
# php cli.php seed:initial

echo "Installer is finished."