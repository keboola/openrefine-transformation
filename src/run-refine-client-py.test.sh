#!/bin/sh

nohup /app/openrefine-2.6-rc.2/refine -i 0.0.0.0 &
python setup.py test
