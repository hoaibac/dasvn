#!/bin/bash

for username in `ls /usr/local/directadmin/data/users`; do
	passwd=`</dev/urandom tr -dc A-Za-z0-9 | head -c 8`;
	echo "User: $username $passwd";

	mkdir /home/$username/svn_settings
	htpasswd -cmb /home/$username/svn_settings/passwd $username $passwd >& /dev/null
	chown -R $username:apache /home/$username/svn_settings/

	for domain in `cat /usr/local/directadmin/data/users/$username/domains.list`; do
		echo "Domain: $domain";


		mkdir /home/$username/domains/$domain/svn_repositories
		mkdir /home/$username/domains/$domain/svn_settings
		echo "" > /home/$username/domains/$domain/svn_settings/authz
		echo "[aliases]" >> /home/$username/domains/$domain/svn_settings/authz
		echo "" >> /home/$username/domains/$domain/svn_settings/authz
		echo "[groups]" >> /home/$username/domains/$domain/svn_settings/authz
		echo "" >> /home/$username/domains/$domain/svn_settings/authz
		echo "[/]" >> /home/$username/domains/$domain/svn_settings/authz
		echo "$username = r" >> /home/$username/domains/$domain/svn_settings/authz
		echo "" >> /home/$username/domains/$domain/svn_settings/authz
		chown -R apache:apache /home/$username/domains/$domain/svn_repositories
		chown -R $username:apache /home/$username/domains/$domain/svn_settings


		done;
	echo "---";
	done;
done;
exit 0;