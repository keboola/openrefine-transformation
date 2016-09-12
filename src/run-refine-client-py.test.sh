#!/bin/sh

supervisord -c /code/supervisor/supervisord.conf
sleep 30
python setup.py test
