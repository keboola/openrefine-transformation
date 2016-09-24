#!/bin/bash
supervisord -c /code/supervisor/supervisord.conf
sleep 30
php ./src/main.php --data=$KBC_DATADIR

