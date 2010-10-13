#!/bin/bash
#username=$1
#passwd=$2
#domain=$3
rm /home/$username/domains/$domain/svn_repositories -rf
rm /home/$username/svn_settings -rf
mkdir /home/$username/svn_settings
mkdir /home/$username/domains/$domain/svn_repositories
mkdir /home/$username/domains/$domain/svn_settings
svnadmin create /home/$username/domains/$domain/svn_repositories/default
echo "" > /home/$username/domains/$domain/svn_settings/authz
echo "[aliases]" >> /home/$username/domains/$domain/svn_settings/authz
echo "" >> /home/$username/domains/$domain/svn_settings/authz
echo "[groups]" >> /home/$username/domains/$domain/svn_settings/authz
echo "" >> /home/$username/domains/$domain/svn_settings/authz
echo "[/]" >> /home/$username/domains/$domain/svn_settings/authz
echo "$username = r" >> /home/$username/domains/$domain/svn_settings/authz
echo "" >> /home/$username/domains/$domain/svn_settings/authz
echo "[default:/]" >> /home/$username/domains/$domain/svn_settings/authz
echo "$username = rw" >> /home/$username/domains/$domain/svn_settings/authz
htpasswd -cmb /home/$username/svn_settings/passwd $username $passwd >& /dev/null
chown -R apache:apache /home/$username/domains/$domain/svn_repositories
chown -R $username:apache /home/$username/domains/$domain/svn_settings/authz
chown -R $username:apache /home/$username/svn_settings/
exit 0;
