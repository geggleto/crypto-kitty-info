#!/usr/bin/env bash

cd /tmp

_now=$(date -v-1d +"%Y%m%d")
_url="http://assets.cryptokittydex.com.s3.amazonaws.com/data/$_now.csv"

wget $_url


php cli/cronProcessDNA.php