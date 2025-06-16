<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic GATUM Project Template</h1>
    <br>
</p>

Yii 2 Basic Project Template for GATUM task is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 8.2.


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](https://getcomposer.org/), you should to install using below commands:

~~~
sudo apt update
sudo apt install php-cli unzip
~~~

Downloading and Installing Composer

~~~
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
HASH=`curl -sS https://composer.github.io/installer.sig`
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
~~~

Then, you can install this project template using the following composer command:

~~~
composer create-project --prefer-dist yiisoft/yii2-app-basic yiibasic
~~~

Installing **vendor** packages

~~~
composer install
~~~

### Environment

Now you should to create **.env** file from **.env.example**.

Generate and set cookie validation key in **.env** file, like value:

~~~
php -r "echo bin2hex(random_bytes(32));"
~~~

### Installation Docker Compose

Use the below commands to download and installing:
~~~
mkdir -p ~/.docker/cli-plugins/
curl -SL https://github.com/docker/compose/releases/download/v2.3.3/docker-compose-linux-x86_64 -o ~/.docker/cli-plugins/docker-compose
~~~

Set the correct permissions so that the docker compose command is executable and verify that the installation was 
successful, for yourself:

~~~
chmod +x ~/.docker/cli-plugins/docker-compose
docker compose version
~~~

### Migration execution

Before, starting the project containers you should:

~~~
// Save permission
sudo chown -R $USER:$USER migrations
~~~
~~~
docker exec -it yii2-basic php yii migrate/up
~~~

> **Yii2 migration works only from php container.**
>

### Starting the containers

~~~
docker-compose up -d --build
~~~

You can then access the application through the following URL:

~~~
http://127.0.0.1:8080
~~~
> **NOTES:**
> The default configuration uses a current catalog project yii2_db volumes.



CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, from docker-compose.yaml file:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=db;dbname=yii2basic',
    'username' => 'yii2user',
    'password' => 'yii2pass',
    'charset' => 'utf8',
];
```
