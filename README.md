Kisakone
========

Kisakone is [Finnish Disc Golf Associations (Suomen frisbeegolfliitto ry)](http://frisbeegolfliitto.fi/)
disc golf tournament management software, which powers all the sanctioned disc golf events in Finland.

Live version is running at [Kisakone](https://kisakone.frisbeegolfliitto.fi/) along with many copies operated by
local disc golf clubs in Finland.


Installation
============

See [INSTALL](https://github.com/tuminoid/kisakone/blob/master/doc/install/INSTALL.md). LAMP setup is required,
but Kisakone has very limited dependencies. Mainly few PHP modules.
Apache is supported by default, but you can run Kisakone with Nginx + HHVM if you like.


Upgrading
=========

You can upgrade by doing a `git fetch` followed by `git checkout <version you want>` AND then executing upgrade steps,
in order, up to the version to chose to upgrade to. See
[UPGRADE.md](https://github.com/tuminoid/kisakone/blob/master/doc/upgrade/UPGRADE.md)

List of ugprades that require additional steps is available at
[upgrade](https://github.com/tuminoid/kisakone/tree/master/doc/upgrade) directory.


Development
===========

Bleeding edge version is at branch called `next`. `master` aims to be stable and is usually updated when there
is a new release, along with a release tag. Release tags are the ones you want to use for production.

For development, clone [kisakone-dev](https://github.com/tuminoid/kisakone-dev) at same directory level as `kisakone`.
There is ready-made setup for Vagrant VM, usable for local development.


Built with
==========

Kisakone is a legacy project, built originally with PHP 5.2, Smarty templating engine, jQuery and TinyMCE editor.
Output is XHTML for non-IE browsers.

Current list of requirements and frameworks in use:
 - [PHP 5.3](http://www.php.net/) (use [HHVM](http://hhvm.com/), it works 100%)
 - [Smarty](http://www.smarty.net/) (latest 2.6 series, 2.6.28)
 - [jQuery](http://jquery.com/) and [jQuery UI](http://jqueryui.com/) (latest 1.x series, 1.11.2)
 - [jQuery DateTimePicker](http://trentrichardson.com/examples/timepicker/) add-on
 - [jQuery Autocomplete](https://www.devbridge.com/sourcery/components/jquery-autocomplete/) add-on
 - [TinyMCE](http://www.tinymce.com/) (latest 3.5 series)
 - [Flag-icon CSS](https://github.com/lipis/flag-icon-css)
 - [AddThisEvent](http://www.addthisevent.com/) widgets
 - [Google Analytics](http://www.google.com/analytics/) support
 - [TrackJS](http://www.trackjs.com/) support

Long-term plan is to modernize codebase, move to HTML5 and support mobile clients as first-class citizens.
