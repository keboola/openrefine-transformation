#!/bin/bash
supervisord -c /code/supervisor/supervisord.conf
sleep 60
php ./src/main.php --data=$KBC_DATADIR

