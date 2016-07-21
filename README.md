# Lagertha
**PLEASE NOTE: This is still early in the works so it probably won't work quite yet!**

**Lagertha** is an easy-to-use tool for the basic management of Linux devices. 

![Alt text](https://github.com/aaronprisk/lagertha/blob/master/images/lagertha-dash.png "Lagertha Dashboard")

![Alt text](https://github.com/aaronprisk/lagertha/blob/master/images/lagertha-hosts.png "Lagertha Dashboard")

Lagertha consists of two components:

>**Lagertha Server** - Creates manages tasks for Lagertha connected Clients

> **Lagertha Client** - Service that runs on client devices and processes tasks


## Features

 * Easy-to-use Bootstrap powered Dashboard
 * Client Registration and Hostnaming
 * Remotely Add/Remove Packages
 * Remotely Update Repos and Upgrade Packages
 * Remotely Change Wallpaper


## Installation

These steps are for installing Lagertha on an Ubuntu Server 14.04 box. Lagertha will likely run on most modern distros that have a LAMP/FAMP stack.
```
$ sudo apt-get install apache2 mysql-server php5-mysql git
```
Run the MySQL Secure Installation and set your MySQL root Password
```
$ sudo mysql_secure_installation
```
Create Lagertha directory and clone Lagertha Repo to local file
```
$ mkdir lagertha
$ cd lagertha
$ git clone https://github.com/aaronprisk/lagertha.git
```
Run Lagertha install script
```
$ cd bin
$ sudo ./install-lagertha.sh
```
Lagertha Server is now ready to go! Browse to your Lagertha server's IP in yuor favorite browser and log in using *lagertha/lagertha* as your username and password.

## Whats with the name?

The name Lagertha is in honor of the badass shield maiden from Norse legends.


## Some Considerations

This project is still very young so please be careful running Lagertha in production. 
