# Lagertha
**PLEASE NOTE: This is still early in the works so it may not work as expected!**

**Lagertha** is an easy-to-use tool for the basic management of Linux devices. 

![Alt text](https://github.com/aaronprisk/lagertha/blob/master/images/dash-lag-2.png "Lagertha Dashboard")

![Alt text](https://github.com/aaronprisk/lagertha/blob/master/images/host-lag-2.png "Lagertha Host Management")

![Alt text](https://github.com/aaronprisk/lagertha/blob/master/images/logs-lag-2.png "Lagertha Task Logs")

![Alt text](https://github.com/aaronprisk/lagertha/blob/master/images/media-lag-2.png "Lagertha Media")

Lagertha consists of two components:

>**Lagertha Server** - Creates, manages and logs tasks for Lagertha connected Clients.

> **Lagertha Client** - Service that runs on client devices and processes tasks created by Lagertha Server.


## Features

 * Easy-to-use Bootstrap powered Dashboard
 * Client Registration and Hostnaming
 * Remotely Add/Remove Packages
 * Remotely Update Repos and Upgrade Packages
 * Remotely Change Wallpaper


## Installation

These steps are for installing Lagertha on an Ubuntu Server 16.04.03 box. Lagertha will likely run on most modern distros that have a LAMP stack.
```
$ sudo apt-get install apache2 mysql-server php-mysql git
```
Run the MySQL Secure Installation and set your MySQL root Password
```
$ sudo mysql_secure_installation
```
Create Lagertha directory and clone Lagertha Repo to local file
```
$ git clone https://github.com/aaronprisk/lagertha.git
```
Run Lagertha install script
```
$ cd lagertha/bin
$ sudo ./install.sh
```
Lagertha Server is now ready to go! Browse to your Lagertha server's IP in your favorite browser and log in using *lagertha/lagertha* as your username and password.

## Next Step

Now that you have a working Lagertha Server, it's time to add in some hosts. Head on over to https://github.com/aaronprisk/lagertha-client and follow the steps.

## Whats with the name?

The name Lagertha is in honor of the badass shield maiden from Norse legends.

## Some Considerations

This project is still very young so please be careful running Lagertha in production. 
