#!/bin/bash
MONGODB_URI=${1}
if [ -z ${MONGODB_URI} ]
then
    read -p "MONGODB URI (Required): " MONGODB_URI
fi 

echo "Executing ... "
docker run --rm -e MONGODB_URI=${MONGODB_URI} \
    -v "$(pwd)":/workspace/php \
    -w /workspace/php ghcr.io/mongodb-developer/get-started-php:0.1 \
    "php getstarted.php"
