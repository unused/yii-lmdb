lmdb
====

About
-----

lmdb is a personal/social movie database built with the yii framework.


Installation
------------

### Include yii framework

    $ mkdir protected/vendor
    $ cd protected/vendor
    $ http://yii.googlecode.com/files/yii-1.1.5.r2654.tar.gz
    $ tar xzf yii-1.1.5.r2654.tar.gz
    $ rm yii-1.1.5.r2654.tar.gz
    $ mv yii{-1.1.5.r2654,}


### Create database

    # database setup
    $ mysqladmin -uroot create lmdb
    $ cd protected/data
    $ mysql -uroot lmdb < schema.mysql.sql

    # perform migrations
    #   works on zsh
    $ mysql -uroot lmdb < [0-9]*.sql
    #   works on bash
    $ cat [0-9]*.sql | mysql -uroot lmdb

    # add admin user
    $ mysql -uroot ldmb < add-admin-user.sql


### Configure

Copy `protected/config/console.php.example` to `protected/config/console.php`
and `protected/config/main.php.example` to `protected/config/main.php.example`.
Edit the DB configuration in both files.

Set write permissions to `/assets` and `/images/upload`.


Login with admin/admin
