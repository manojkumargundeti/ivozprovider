#!/bin/bash
set -e
pushd /opt/irontec/ivozprovider/microservices/realtimego/cmd/server
    dlv debug --headless --listen=:2345 --api-version=2
popd
