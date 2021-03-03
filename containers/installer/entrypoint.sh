
set -e
set -x


ENV_TO_USE=${ENV_DESCRIPTION:=default}

echo "ENV_TO_USE is ${ENV_TO_USE}";

php composer.phar install

# Generate config settings used per environment
php vendor/bin/classconfig \
    -p config.source.php \
    "PhpOpenDocs\\Config" \
    config.generated.php \
    $ENV_TO_USE

# php cli.php misc:wait_for_db

# php vendor/bin/phinx migrate -e internal

# php cli.php seed:initial

echo "Installer is finished, site should be available."