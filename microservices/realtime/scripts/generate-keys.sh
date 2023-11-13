#!/bin/bash

cd $(dirname $(realpath $0))/..

mkdir -p configs/jwt/

if [ ! -f configs/jwt/public.pem ]; then
    openssl req -nodes -new -x509 \
          -keyout configs/jwt/private.pem \
          -out configs/jwt/public.pem \
          -subj "/C=ES/ST=Bizkaia/L=Bilbao/O=Irontec S.L./CN=realtime.irontec.com"
fi
