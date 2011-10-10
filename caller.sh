#!/bin/bash
while true
do
  php /var/www/hail_katrina/drop_packed.php&
  pid=$!
  sleep 7
  kill -SIGKILL $pid
done
