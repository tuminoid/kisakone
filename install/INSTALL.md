Setting up Kisakone:
--------------------

For the purposes of this file, we'll assume the installation happens at the
directory `.` and is accessible through `http://example.com/kisakone/`

1. Extract and/or copy the extracted files to a location which is accessible
through the web server you intend to use. This should be the final location as well.

2. You need to make sure `config.php` in the installation root directory can be
written to by the web server.

3. Have a database available in mysql, or create one for Kisakone. Installation
process will not create one for you.

4. Access the page `install/install.php` in the installation root using your browser,
in the example that would be `http://example.com/kisakone/install/install.php`

5. Enter the requested details and submit the form.

6. It is recommended, although not strictly necessary to prevent the web
server from writing to `config.php` again.

7. The directory `ui/elements/uploaded` and `Smarty/templetes_c` needs to be
writable by the web server.

8. Copy `config_site.php.sample` to `config_site.php` and modify the email
address for the administration and Kisakone's name, and set the definess
correctly for club use.


Setting up LAMP for Kisakone:
-----------------------------

In Ubuntu:
Good generic guide for setting LAMP:
https://help.ubuntu.com/community/ApacheMySQLPHP

Step by step:
```
$ sudo apt-get install mysql-server apache2 libapache2-mod-php5 php5 php5-mysql
$ sudo a2enmod php5
$ sudo a2enmod rewrite
```

Edit `/etc/apache2/sites-enabled/000-default` to point to your local sources,
then restart the server:

```
$ sudo service apach2 restart
```


Set up Postfix
--------------

If you want to send out emails (reminders, TDs messages, password reset links):
When prompted, select `Internet Site` and enter your domain name.

```
$ sudo apt-get install postfix
```


Using VagrantUp as development:
-------------------------------

VagrantUp is a headless virtual machine that can be instantiated and destroyed
at a whim, to be recreated identically again. This way it can provide exact same
development environment for all developers. System works on Linux, Windows, Mac
etc, so host is not an issue. You just ssh in to your vagrantup box.

Steps to run development on vagrantup:

1. Install VagrantUp for your host: http://www.vagrantup.com/
2. Install Virtualbox and Extensions: http://www.virtualbox.org/
3. In Kisakone git, go to `tools/vagrantup/apache2`, execute `vagrant up`
4. When it says it has completed, execute `vagrant ssh` to have shell to your
   installation. `sudo` is passwordless for you.
5. Webroot is set to `/kisakone`, which is shared from Kisakone folder from your host,
   so you can edit files your host with your favourite editor and it is synced
   to vagrant automatically.
6. Create database in mysql, mysql pass is `pass`
7. Go to Kisakone installation guide on top of this file.
8. Hack & enjoy.
