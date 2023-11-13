#!/bin/bash

set -xe

cd $(dirname $(realpath $0))/..

# Download required dependencies
go mod download && go mod verify

# Build server
go build -v -o deitu-server irontec.com/realtime/cmd/server
