#!/usr/bin/env bash

NAME=brofist_test_couchbase
CB_REST_USERNAME=Administrator
CB_REST_PASSWORD=password
SLEEP_TIME=20

function info_msg () {
  echo -e "\n----------------> $@\n";
}


info_msg "(re)creating docker container..."

docker rm -f $NAME

set -e

docker run -d              \
  --name $NAME             \
  -p 8091-8094:8091-8094   \
  -p 11210:11210 couchbase

sleep $SLEEP_TIME

# http://developer.couchbase.com/documentation/server/4.0/install/dp4-setup-cli-rest.html

info_msg "Set up server..."

docker exec -i                         \
  -t $NAME                             \
  couchbase-cli cluster-init           \
  --cluster-username=$CB_REST_USERNAME \
  --cluster-password=$CB_REST_PASSWORD \
  --cluster-index-ramsize=256          \
  --cluster-ramsize=256                \
  --index-storage-setting=default      \
  --services=data,index,query

info_msg "Creating test bucket..."

docker exec -i \
  -t $NAME     \
  couchbase-cli bucket-create -c localhost:8091 -u $CB_REST_USERNAME -p $CB_REST_PASSWORD --bucket=test_bucket --bucket-ramsize=100 --wait

info_msg "Creating test bucket PRIMARY INDEX..."

sleep $SLEEP_TIME

docker exec -i                              \
  -t $NAME                                  \
  /opt/couchbase/bin/cbq                    \
  -u $CB_REST_USERNAME -p $CB_REST_PASSWORD \
  --script='CREATE PRIMARY INDEX `test-bucket-index` ON `test_bucket` USING GSI;';
