#!/bin/sh

nohup /app/OpenRefine-2.6-beta.1/refine -i 0.0.0.0 &
mvn package

