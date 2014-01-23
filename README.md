CakeUser
========
CakeUser is a bootstrapper for authentication and permission needs in a CakePHP 2.x app

This plugin is intended to provide the authentication and permission management out of the box. It is heavily configurable and has been developed with simplicity, localisation and internationalisation in mind.

This plugin utilizes the core ACL and Auth to the best extend and only implements the missing functionality in order you dont need to rewrite one code multiple times.

## Install
Proper installation is done in multiple steps that are listed bellow. Follow all of them until you have a fully functional access controll.

### Setting up the plugin
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
	'Acl',
    'Auth' => array(
        'loginAction' => array(
            'plugin' => 'CakeUser',
            'controller' => 'cake_user_users',
            'action' => 'login'
        ),
        'authenticate' => array(
            AuthComponent::ALL => array('userModel' => 'CakeUser.CakeUserUser'),
            'Form'
        ),
    ),
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

### Register first user
We assume the first user who is registered is the administrator. To prevent further problems, just after installing the plugin, naviagte to ```http://yourserveraddress.com/cake_user/cake_user_users/register```, fill the form and register your first user.

The schema file contains some pre-filled user groups. The first group is a neutral group which will be also assigned to all new registrations, keep that in mind.

To activate your first user, you have to access the database directly and set the ```is_active``` field to ```1``` inside ```users``` table.

### Create ACOs
If you want to use the recommended controller/action setup for ACOs, you will need probably a tool to generate the ACOs automatically and not per hand. In this case installing the [AclExtras](https://github.com/markstory/acl_extras/) plugin is recommended.

Follow installtion process and ACO generation from [AclExtras](https://github.com/markstory/acl_extras/) page.

After installtion of that plugin is done, your ```Auth``` config has to look like as follows:
```php
public $components = array(
	'Acl',
    'Auth' => array(
        'loginAction' => array(
            'plugin' => 'CakeUser',
            'controller' => 'cake_user_users',
            'action' => 'login'
        ),
        'authenticate' => array(
            AuthComponent::ALL => array('userModel' => 'CakeUser.CakeUserUser'),
            'Form'
        ),
        'authorize' => array(
            AuthComponent::ALL => array('userModel' => 'CakeUser.CakeUserUser'),
            'Actions' => array('actionPath' => 'controllers')
        ),
    ),
);
```
You can sync your ACOs now by following command:
```
./Console/cake AclExtras.AclExtras aco_sync
```

If you want to generate your ACOs yourself, do it and then move to next step.

### Give first permission
At this point you may need to grant your administrator access to all of the ```controllers``` (or any other root ACO that you have created), run following command to do so:
```
./Console/cake acl grant CakeUserUser.1 controllers
```

At this point you are setup and ready, navigate to any address on your site and login using the administrator (first user) you just registered and you should be able to see the page.

## Change the route
In order to access the plugin's actions with a custom path add following to your ```routes.php``` file:
```php
Router::connect('/members/:action/*', array('plugin' => 'cake_user', 'controller' => 'cake_user_users'));
Router::connect('/members/*', array('plugin' => 'cake_user', 'controller' => 'cake_user_users'));

Router::connect('/members_groups/:action/*', array('plugin' => 'cake_user', 'controller' => 'cake_user_user_groups'));
Router::connect('/members_groups/*', array('plugin' => 'cake_user', 'controller' => 'cake_user_user_groups'));
```

## License
This plugin ins licensed under MIT license.