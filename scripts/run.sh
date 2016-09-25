#!/bin/bash
supervisord -c /code/supervisor/supervisord.conf
php ./src/main.php --data=$KBC_DATADIR

