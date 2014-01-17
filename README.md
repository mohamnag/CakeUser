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

Import the sql file from ```app/Plugin/CakeUser/Config/Schema/cakeuser.sql``` into your database.

Change config in ```app/Plugin/CakeUser/Config/bootstrap.php``` where necessary.