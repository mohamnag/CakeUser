CakeUser
========
CakeUser is a bootstrapper for authentication and permission needs in a CakePHP 2.x app

This plugin is intended to provide the authentication and permission management out of the box. It is heavily configurable and has been developed with simplicity, localisation and internationalisation in mind.

This plugin utilizes the core ACL and Auth to the best extend and only implements the missing functionality in order you dont need to rewrite one code multiple times.

## Install
Add the plugin as submodule using GIT, or just download it and paste it into ```app/Plugin``` folder.

Inside your ```app/bootstrap.php``` add the following line:

```php
CakePlugin::loadAll(array(
    'CakeUser' => array('bootstrap'=>true, 'route'=>true)
));
```

Add and config the ```Auth``` component as below in your ```app/AppController.php```:
```php
public $components = array(
    'Auth' => array(
        'loginAction' => array(
            'plugin' => 'cake_user',
            'controller' => 'users',
            'action' => 'login'
        ),
        'authenticate' => array(
            'Form' => array('userModel' => 'CakeUser.User')
        )
    )
);
```

> If you have any of the following tables, its going to be dropped by importing the sql file:
> - users
> - user_groups
> - acos
> - aros
> - aros_acos

Import the sql file from ```app/Plugin/CakeUser/Config/Schema/cakeuser.sql``` into your database.

Change config in ```app/Plugin/CakeUser/Config/bootstrap.php``` where necessary.

## Prefilled content
The schema file contains some prefilled content in order not to block access to site as plugin gets installed. There are two groups and one user included. One of the groups is used as the default group which is assigned to users who just sign up. The other is for administrators.
The ```admin``` user has the password ```administrator``` which is highly recommended to be changed just after installation.
