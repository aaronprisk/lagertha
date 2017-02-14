#!/bin/bash
# Install Script for Lagertha Server
# Verson 1.0
# Last Tested on Ubuntu Server 16.04
# https://github.com/aaronprisk/lagertha


touch lag-install.log
echo "* Installing required packages"
echo "* You may be prompted for MySQL passwords if not previously installed"
sudo apt -y install apache2 php libapache2-mod-php php-mysql wget mysql-server >> lag-install.log

echo "* Setting up MySQL Databases and Tables. You will be prompted for your MySQL root password."
echo "* Creating DBs"
mysql -u root -p < db.sql >> lag-install.log
echo "* Creating User Tables"
mysql -u root -p < tables.sql >> lag-install.log
echo "* Creating default user account"
mysql -u root -p < users.sql >> lag-install.log
echo "* Creating Lagertha Tables"
mysql -u root -p < lagertha.sql >> lag-install.log

echo "* Setting up webroot files"
sudo cp ../* /var/www/html/ >> lag-install.log
sudo rm -R /var/www/html/bin/
sudo rm /var/www/html/README.md

echo "* Setting permissions"
sudo chown -R www-data:www-data /var/www/html/ >> lag-install.log

echo "--------------------------------------------------------"
echo "Lagertha Server install process is complete!"
echo "If errors occured, check lag-install.log for details."
echo "--------------------------------------------------------"
ip=$(hostname -I)
echo "To log into Lagertha Dashboard, browse to http://$ip"
echo "Default User: lagertha"
echo "Default Password: lagertha"
