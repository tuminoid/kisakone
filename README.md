Kisakone
========

Kisakone is Finnish Disc Golf Associations disc golf tournament management software.

Complete and separate fork from [lekonna's SFL-disc-golf-engine](https://github.com/lekonna/SFL-disc-golf-engine). Kudos to previous maintainers.


Installation
============

See [INSTALL](https://github.com/tuminoid/kisakone/blob/master/doc/install/INSTALL.md). PHP and MySQL are required,
but Kisakone runs pretty much anywhere. Apache is supported by default, but you can run Kisakone with Nginx+HHVM if you like.

Upgrading
=========

You can upgrade by doing a `git fetch` followed by `git checkout <version you want>` AND then executing upgrade steps, in order, up to the version to chose to upgrade to.

List of ugprades that require additional steps is available at [upgrade](https://github.com/tuminoid/kisakone/tree/master/doc/upgrade) directory.

Development
===========

Bleeding edge version is at branch called `next`. `master` aims to be stable and is usually updated when there
is a new release, along with a release tag.
Releases are the ones you want to use for production.

For development, clone [kisakone-dev](https://github.com/tuminoid/kisakone-dev) at same directory level as `kisakone`.
There is ready-made setup for Vagrant VM, usable for local development.
