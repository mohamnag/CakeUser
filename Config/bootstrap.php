<?php
/**
 * CakeUser
 * 
 * @author Mohammad Naghvi <mohamnag@gmail.com>
 * 
 * The most important configs realy at the begining.
 */

Configure::write('CakeUser.DbConfig', 'asui');

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

Configure::write('CakeUser.Validation.User', array(
    'DuplicateUsername'     => 'This user name is already registered',
    'ShortPassword'         => 'Passwords should be at least 8 characters long',
    'PasswordsNotMatch'     => 'Passwords you entered does not match',
));

Configure::write('CakeUser.Validation.UserGroup', array(
    'EmptyTitle'            => 'Title can not be left empty',
    'LongTitle'             => 'Title can be of max 100 characters long',
));
