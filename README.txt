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
    $ wget http://www.yiiframework.com/files/yii-1.1.3.tar.gz
    $ tar xzf yii-1.1.3.tar.gz
    $ rm yii-1.1.3.tar.gz
    $ mv yii-1.1.3.r2247 yii


### Create database

    $ mysqladmin -uroot create lmdb
    $ cd protected/data
    $ mysql -uroot lmdb < schema.mysql.sql 
    # works on zsh
    $ mysql -uroot lmdb < [0-9]*.sql 
    # add admin user
    $ mysql -uroot ldmb < add-admin-user.sql


### Configure

Copy `protected/config/console.php.example` to `protected/config/console.php`
and `protected/config/main.php.example` to `protected/config/main.php.example`.
Edit the DB configuration in both files.

Set write permissions to `/assets` and `/images/upload`.


Login with admin/admin.
