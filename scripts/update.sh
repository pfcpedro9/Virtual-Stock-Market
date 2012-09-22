#!/usr/bin/sh
while [ 1 ]
do
	python extractstock.py
	php update_portfolios.php
        php update_rank.php
	sleep 5
done
