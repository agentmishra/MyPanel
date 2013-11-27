#!/bin/bash
# deletes account

# username as $1

unlink /var/www/pub_sites/$1
rm -rf /var/www/pub_sites/$1
userdel $1
rm -rf /home/$1

echo Account $1 deleted.