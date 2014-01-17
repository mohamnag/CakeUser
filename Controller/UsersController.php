<?php

/**
 * @property User $User 
 */
class UsersController extends CakeUserAppController {
    public $uses = array('CakeUser.User');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'register');
    }

    public function login() {
        if ($this->request->is('POST')) {
            if ($this->Auth->login()) {
                if (!$this->Auth->user('is_active')) {
                    $flash = Configure::read('CakeUser.Flash.NotActivated');
                    $this->Session->setFlash($flash['message'], $flash['element'], $flash['params'], $flash['key']);
                    $this->Auth->logout();
                } else {
                    return $this->redirect($this->Auth->redirectUrl());
                }
            } else {
                $flash = Configure::read('CakeUser.Flash.LoginFailed');
                $this->Session->setFlash($flash['message'], $flash['element'], $flash['params'], $flash['key']);
            }
        }
    }

    public function register() {
        if ($this->request->is('POST')) {
            if ($this->User->save($this->request->data)) {
                $flash = Configure::read('CakeUser.Flash.Registered');
                $this->Session->setFlash($flash['message'], $flash['element'], $flash['params'], $flash['key']);
                $this->redirect(array('action' => 'login'));
            } else {
                $flash = Configure::read('CakeUser.Flash.RegistrationFailure');
                $this->Session->setFlash($flash['message'], $flash['element'], $flash['params'], $flash['key']);
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

}
