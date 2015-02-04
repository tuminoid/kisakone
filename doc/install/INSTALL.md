Setting up Kisakone:
--------------------

For the purposes of this file, we'll assume the installation happens at the
directory `.` and is accessible through `http://example.com/kisakone/`

1. `git clone` Kisakone files to a location which is accessible
through the web server you intend to use. This should be the final location as well.
Using a git clone enables you much easier upgrades than installing from a tarball.

2. You need to make sure `config.php` in the installation root directory can be
written to by the web server.

3. Have a database available in MySQL, or insert admin credentials to allow
install script to create one for Kisakone.

4. Access the page `doc/install/install.php` in the installation root using your browser,
in the example that would be `http://example.com/kisakone/doc/install/install.php`

5. Enter the requested details and submit the form.

6. It is recommended, although not strictly necessary to prevent the web
server from writing to `config.php` again.

7. The directory `images/uploaded` and `Smarty/templetes_c` needs to be
writable by the web server.

8. Copy `config_site.php.example` to `config_site.php` and modify the email
address and other configuration information for the administration and Kisakone's name.


Setting up LAMP for Kisakone:
-----------------------------

In Ubuntu:
Good generic guide for setting LAMP:
https://help.ubuntu.com/community/ApacheMySQLPHP

Step by step:
```
$ sudo apt-get install mysql-server apache2 libapache2-mod-php5 php5 php5-mysql php5-curl php5-mcrypt
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
