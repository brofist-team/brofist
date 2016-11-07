#!/usr/bin/env bash

NAME=brofist_test_couchbase
CB_REST_USERNAME=Administrator
CB_REST_PASSWORD=password

docker rm -f $NAME

docker run -d              \
  --name $NAME             \
  -p 8091-8094:8091-8094   \
  -p 11210:11210 couchbase

sleep 5

docker exec -i \
  -t $NAME     \
  couchbase-cli bucket-create -c localhost:8091 -u $CB_REST_USERNAME -p $CB_REST_USERNAME --bucket=test_bucket --bucket-ramsize=100 --wait
