#!/bin/bash
echo "Starting tests" >&1
php --version \
    && composer --version \
    && composer install \
    && /code/vendor/bin/phpcs --standard=psr2 -n --ignore=vendor --extensions=php . \
    && /code/vendor/bin/phpunit

RUN=$(php /code/src/main.php)
if [ "$RUN" == "Data folder not set." ] ; then
    echo "Folder OK"
else
    echo "Folder Fail: $RUN"
    exit 1
fi

RUN=$(php /code/src/main.php --data=/tmp/)
if [ "$RUN" == "config.json file not found" ] ; then
    echo "Config OK"
else
    echo "Config Fail: $RUN"
    exit 1
fi

touch /tmp/config.json
RUN=$(php /code/src/main.php --data=/tmp/)
if [ "$RUN" == "Script not defined." ] ; then
    echo "Script OK"
else
    echo "Script Fail: $RUN"
    exit 1
fi

echo "{\"parameters\": {\"script\": \"fooBar\"}}" > /tmp/config.json
RUN=$(php /code/src/main.php --data=/tmp/)
if [ "$RUN" == "Source data file not found." ] ; then
    echo "Data OK"
else
    echo "Data Fail: $RUN"
    exit 1
fi

echo "Tests finished" >&1
