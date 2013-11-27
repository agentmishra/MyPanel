#!/bin/bash
# deletes account

# username as $1

if [ $(id -u) != 0 ]; then
        echo "You need to be logged in as root to perform this operation";
        exit 1;
fi

if [ $# -ne 1 ]; then
        echo "Usage: $0 username";
        exit 1;
fi

unlink /var/www/pub_sites/$1
rm -rf /var/www/pub_sites/$1
userdel $1
rm -rf /home/$1

echo Account $1 deleted.
