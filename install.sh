#!/bin/bash
composer global require "fxp/composer-asset-plugin:^1.3.1"
composer create-project --repository=composer.json

mysql-ctl start
mysql -u$C9_USER -e "CREATE DATABASE yii2basic /*\!40100 DEFAULT CHARACTER SET utf8 */;"
# replace root with c9 username
sed -i -e "s~root~${C9_USER}~g" config/db.php
RANDOMKEY=$(date +%s | sha256sum | base64 | head -c 32)
#sed -i -e "s~RANDOMKEY~${RANDOMKEY}~g" config/web.php
sed -i "34s/.*/\t\t'cookieValidationKey' => '${RANDOMKEY}',/" config/web.php
sed -i -e "s~URNAME~${HGUSER}~g" config/web.php
# install yii2-user
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations --interactive=0
php yii migrate/up --migrationPath=@yii/rbac/migrations --interactive=0
# CREATE USER
./yii user/create $C9_EMAIL $HGUSER $yii2passwd

#install phpmyadmin
#phpmyadmin-ctl install

sudo mv 001-cloud9.conf  /etc/apache2/sites-available/001-cloud9.conf
read -p "set password for $HGUSER" yii2passwd
echo -e "site user: $HGUSER \npassword : $yii2passwd"
rm install.sh
