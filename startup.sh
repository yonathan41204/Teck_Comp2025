#!/bin/bash
service nginx stop
cp /home/site/wwwroot/public/nginx.conf /etc/nginx/nginx.conf
service nginx start
chmod +x startup.sh
