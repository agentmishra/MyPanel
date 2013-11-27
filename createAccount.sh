#!/bin/bash
# creates account

# username as $1
# password as $2

if [ $# -ne 2 ]; then
        echo "Usage: $0 username password";
        exit 1;
fi

useradd -d /home/$1 -m $1 -p $2
echo User $1 added

mkdir /home/$1/public_html

echo Created public_html directory for $1
mkdir /var/www/pub_sites/$1

ln -s /var/www/pub_sites/$1 /home/$1/public_html/www
