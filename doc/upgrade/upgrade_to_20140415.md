Upgrading to version 2014.04.15:
================================

Files have been reorganized to make some sense. No actions related to
these items are necessary:
 - Javascript files have been moved from `ui/elements/` to `js/`
 - Image files have been moved from `ui/elements/` to `images/`
 - CSS files have been moved from `ui/elements` to `css/`

These files must be manually moved as they are not part of the Git repository:
 - `ui/elements/uploaded` -> `images/uploaded`. Take care of the directory ownership.
 - SFL's `favicon.ico` is not enabled by default. Use your own at the root or link the SFL icon
     from `sfl/images/favicon.ico` to the root
 - `analytics.js` is now searched from the standard `js/` directory

Addition to the `config_site.php.sample` was made:
```
error_reporting(E_ERROR);
```

It is server-configuration dependent, but does no harm, so enabling it is couraged.
