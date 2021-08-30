#! /bin/bash


php artisan queue:work > /dev/null 2>&1 &
PID1="$!"

php artisan queue:work > /dev/null 2>&1 &
PID2="$!"

php artisan queue:work > /dev/null 2>&1 &
PID3="$!"

php artisan queue:work > /dev/null 2>&1 &
PID4="$!"

trap "kill $PID1 $PID2 $PID3 $PID4" exit INT TERM

wait
