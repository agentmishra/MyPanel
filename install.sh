#!/bin/bash
# $1 as a secure password for configuration
echo -------------------------------
echo ----- My Panel Installer ------
echo ----- By SrsX @ VPSBoard ------
echo ----- Version: v1.0-beta ------
echo -------------------------------

echo --------------------------------
echo ----- Supported OS: Ubuntu -----
echo ----- Coming soon: CentOs  -----
echo ----- Coming soon: Debian  -----
echo --------------------------------

echo ---------------------------------
echo ----- Starting Installation -----
echo ---------------------------------

if [ $(id -u) != 0 ]; then
	echo "You need to be logged in as root to perform this operation";
	exit 1;
fi


# Create a account to store files - isolated from root
useradd -d /home/mypanel_main -m mypanel_main -p $1
echo Created mypanel_main account with password $1

mkdir /home/mypanel_main/public_html
wget https://github.com/SrsX/MyPanel/archive/master.zip
cp -r master.zip /home/mypanel_main/public_html

cd /home/mypanel_main/public_html
unzip master.zip
rm -rf README.md

cd ~
if [ "$2" == "apache" ]; then
	echo Using apache
	apt-get install apache2 php5 php5-mysql php-pear php5-dev phpmyadmin
	/etc/init.d/apache2 stop # incase running already
	/etc/init.d/apache2 start # start apache2
else
	echo Using nginx
	apt-get install nginx
	apt-get install mysql-server mysql-client
	apt-get install php5-fpm
	apt-get install phpmyadmin
	/etc/init.d/nginx stop # incase its running already
	/etc/init.d/nginx start # start nginx

	echo --- Note: May require manual configuration ---
fi

echo ------------------------------------------------------------
echo ---- 			Installation has been completed 		 ----
echo ---- Please ensure to lockdown MySQL with a Password    ----
echo ---- Please ensure to update the configuration.php file ----
echo ------------------------------------------------------------
