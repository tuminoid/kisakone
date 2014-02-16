Upgrading to version 2014.02.13:
================================

Steps to upgrade to version 2014.02.13:

 1. config_email.php was deprecated and new configs added. New name config_site.php,
    see config_site.php.sample. 
    Upgrade: `cp config_site.php.sample -> config_site.php` + edit it
             `rm config_email.php`.
 2. Sitelogo name was changed: `ui/elements/logo2.png` -> `ui/elements/sitelogo.png`
 3. Sitelogo height: 120px -> 80px, with 20px margin (adjust in `ui/elements/style.css`) 
 4. `htaccess.sample` was renamed to `.htaccess`, which may conflict with existing installation.
 5. `favicon.ico` was added. Might conflict with existing installation.


