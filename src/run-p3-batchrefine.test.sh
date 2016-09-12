#!/bin/sh

supervisord -c /code/supervisor/supervisord.conf
sleep 10
mvn package

