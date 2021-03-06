<?php

/**
 * CakeUser
 * 
 * @author Mohammad Naghvi <mohamnag@gmail.com>
 * 
 * The most important configs realy at the begining.
 */
Configure::write('CakeUser.DbConfig', 'asui');
//Configure::write('CakeUser.TablePrefix', 'cake_user_');
Configure::write('Acl.database', 'asui');

Configure::write('CakeUser.Flash.NotActivated', array(
    'message' => __('Your user is not activated, contact an administrator to fix this problem'),
    'element' => 'error',
    'params' => array(),
    'key' => 'auth'
));

Configure::write('CakeUser.Flash.LoginFailed', array(
    'message' => __('Username or password is incorrect'),
    'element' => 'error',
    'params' => array(),
    'key' => 'auth'
));

Configure::write('CakeUser.Flash.Registered', array(
    'message' => __('You have been registered successfully, you can login after your account is activated by and administrator'),
    'element' => 'success',
    'params' => array(),
    'key' => 'auth'
));

Configure::write('CakeUser.Flash.RegistrationFailure', array(
    'message' => __('There was some problems registering your user, please try again later'),
    'element' => 'error',
    'params' => array(),
    'key' => 'auth'
));

Configure::write('CakeUser.Flash.CakeUserUserEdit', array(
    'message' => __('User %s was updated successfully.'),
    'element' => 'success',
    'params' => array(),
    'key' => 'flash'
));

Configure::write('CakeUser.Flash.CakeUserUserDelete', array(
    'message' => __('User %s was deleted successfully.'),
    'element' => 'success',
    'params' => array(),
    'key' => 'flash'
));

Configure::write('CakeUser.Flash.CakeUserGroupEdit', array(
    'message' => __('Users\' group %s was updated successfully.'),
    'element' => 'success',
    'params' => array(),
    'key' => 'flash'
));

Configure::write('CakeUser.Flash.CakeUserGroupAdd', array(
    'message' => __('User group %s was created successfully.'),
    'element' => 'success',
    'params' => array(),
    'key' => 'flash'
));

Configure::write('CakeUser.Flash.CakeUserGroupDelete', array(
    'message' => __('User group %s was deleted successfully.'),
    'element' => 'success',
    'params' => array(),
    'key' => 'flash'
));

Configure::write('CakeUser.Flash.PermissionsUpdate', array(
    'message' => __('Group\'s permissions were updated successfully.'),
    'element' => 'success',
    'params' => array(),
    'key' => 'flash'
));

Configure::write('CakeUser.Validation.CakeUserUser', array(
    'DuplicateUsername' => __('This user name is already registered'),
    'ShortPassword' => __('Passwords should be at least 8 characters long'),
    'PasswordsNotMatch' => __('Passwords you entered does not match'),
));

Configure::write('CakeUser.Validation.CakeUserGroup', array(
    'EmptyTitle' => __('Title can not be left empty'),
    'LongTitle' => __('Title can be of max 100 characters long'),
));

Configure::write('CakeUser.Exception', array(
    'CakeUserUserNotFound' => __('The requested user was not found'),
    'CakeUserGroupNotFound' => __('The requested group was not found'),
));
