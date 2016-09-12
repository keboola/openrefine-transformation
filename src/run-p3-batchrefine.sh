#!/bin/sh

# supervisord -c /code/supervisor/supervisord.conf
# sleep 10
jq -r ".parameters.script[0]" /data/config.json  > /data/transformation.json
/app/p3-batchrefine/bin/batchrefine embedded /data/in/tables/data.csv /data/transformation.json /data/out/tables/data.csv

