#!/bin/bash
docker login -u="$QUAY_USERNAME" -p="$QUAY_PASSWORD" quay.io
docker tag keboola/openrefine-transformation quay.io/keboola/openrefine-transformation:$TRAVIS_TAG
docker tag keboola/openrefine-transformation quay.io/keboola/openrefine-transformation:latest
docker images
docker push quay.io/keboola/openrefine-transformation:$TRAVIS_TAG
docker push quay.io/keboola/openrefine-transformation:latest
