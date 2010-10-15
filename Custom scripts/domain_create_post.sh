#!/bin/bash
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
echo "/home/$username/domains/$domain/svn_repositories is created"
exit 0;
