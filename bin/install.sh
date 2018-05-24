#!/bin/bash
# Install Script for Lagertha Server
# Verson 1.0
# Last Tested on Ubuntu Server 16.04
# https://github.com/aaronprisk/lagertha


touch lag-install.log
echo "* Installing required packages"
echo "* You may be prompted to create a MySQL password if not previously installed"
sudo apt-get -y install apache2 php libapache2-mod-php php-mysql wget mysql-server

echo "* Setting MySQL bind address."
sudo sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf 
clear

echo "* Setting up MySQL Databases and Tables. You will be prompted for your MySQL root password."
echo "* Configuring Database"
mysql -u root -p < db.sql >> lag-install.log

echo "* Setting up webroot files"
sudo cp -R ../* /var/www/html/ >> lag-install.log
sudo rm -R /var/www/html/bin/
sudo rm /var/www/html/README.md
sudo rm /var/www/html/index.html

echo "* Setting permissions"
sudo chown -R www-data:www-data /var/www/html/ >> lag-install.log

echo "*Restarting Web Server"
sudo service apache2 restart >> lag-install.log

echo "--------------------------------------------------------"
echo "Lagertha Server install process is complete!"
echo "If errors occured, check lag-install.log for details."
echo "--------------------------------------------------------"
ip=$(hostname -I)
echo "To log into Lagertha Dashboard, browse to http://$ip"
echo "Default User: lagertha"
echo "Default Password: lagertha"
