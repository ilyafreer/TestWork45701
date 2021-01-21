#!/usr/bin/env bash
db_name='`lara-db`'
mysql_params='-uroot -p123456'

mysql $mysql_params << EOF
CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8 COLLATE utf8_general_ci;
EOF
echo "Database $db_name was created"