# Details #

This installation guide is tested with centos

# 1. Compile Apache for subversion #

Install expat-devel

#yum install expat-devel

Recompile apache with the original configure script, all required modules are already activated

#/usr/local/directadmin/custombuild/build apache y

# 2. Install subversion #

Download and extract the required files

#cd /etc

#mkdir svn

#cd svn

#wget https://dasvn.googlecode.com/svn/trunk/Files/subversion-1.6.5.tar.gz

#tar xzf subversion-1.6.5.tar.gz

#cd subversion-1.6.5

#cp -R **../**

#rm -r subversion-1.6.5

#mkdir sqlite-amalgamation

#cd sqlite-amalgamation

#wget http://dasvn.googlecode.com/svn/trunk/Files/sqlite-amalgamation-3.6.13.tar.gz

#tar xzf sqlite-amalgamation-3.6.13.tar.gz

#cd sqlite-amalgamation

#cp sqlite3.c ../


Compile subversion

#./configure --prefix=/usr --with-apxs=/usr/sbin/apxs --with-apr=/usr/bin/apr-config

#make

#make install

#svn help

#/sbin/ldconfig


# 3. Configure Apache for subversion #

Open /etc/httpd/conf/httpd.conf and make shure this lines exists:

LoadModule dav\_svn\_module /usr/lib/apache/mod\_dav\_svn.so

LoadModule authz\_svn\_module /usr/lib/apache/mod\_authz\_svn.so


# 4. Setup scripts #

#cd /usr/local/directadmin/scripts/custom/

#wget "https://dasvn.googlecode.com/svn/trunk/Custom scripts/domain\_create\_post.sh"

#wget "https://dasvn.googlecode.com/svn/trunk/Custom scripts/domain\_destroy\_pre.sh"

#wget "https://dasvn.googlecode.com/svn/trunk/Custom scripts/user\_create\_post.sh"

#cd /usr/local/directadmin/data/templates/custom/

#wget "https://dasvn.googlecode.com/svn/trunk/Custom scripts/virtual\_host2.conf"

#wget "https://dasvn.googlecode.com/svn/trunk/Custom scripts/virtual\_host2\_secure.conf"


make shure you got the folowing permissions:

-rwx------ 1 diradmin diradmin 974 2009-10-22 16:16 domain\_create\_post.sh

-rwx------ 1 diradmin diradmin 82 2009-10-05 10:11 domain\_destroy\_pre.sh

-rwx------ 1 diradmin diradmin 1324 2009-10-05 09:35 user\_create\_post.sh

-rw-r--r-- 1 diradmin diradmin 1636 2009-10-05 09:17 virtual\_host2.conf

-rw-r--r-- 1 diradmin diradmin 1592 2009-10-22 17:09 virtual\_host2\_secure.conf

# 5. Fix alreade created users #

remake virtual hosts for existing users:

#echo "action=rewrite&value=httpd" >> /usr/local/directadmin/data/task.queue

#/usr/local/directadmin/dataskq d

#/etc/init.d/httpd restart


#mkdir /scripts

#cd /scripts/

#wget "http://dasvn.googlecode.com/svn/trunk/Custom scripts/fixcurentusers.sh"

#chmod 755 fixcurentusers.sh

#./fixcurentusers.sh

#rm fixcurentusers.sh


# 6. Install the plugin #

Login to directadmin and navigate to "Plugin manager"

Past the following link into the URL field and install the plugin

http://dasvn.googlecode.com/svn/trunk/Releases/1.4/svn.tar.gz

Login as a user and you should see SVN options.