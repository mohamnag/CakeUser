<?php

/**
 * @property User $User 
 */
class CakeUserUsersController extends CakeUserAppController {

    public $uses = array('CakeUser.User');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'register', 'logout');
    }

    public function login() {
        if ($this->request->is('POST')) {
            if ($this->Auth->login()) {
                if (!$this->Auth->user('is_active')) {
                    $flash = Configure::read('CakeUser.Flash.NotActivated');
                    $this->Session->setFlash($flash['message'], $flash['element'], $flash['params'], $flash['key']);
                    $this->Auth->logout();
                }
                else {
                    return $this->redirect($this->Auth->redirectUrl());
                }
            }
            else {
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
            }
            else {
                $flash = Configure::read('CakeUser.Flash.RegistrationFailure');
                $this->Session->setFlash($flash['message'], $flash['element'], $flash['params'], $flash['key']);
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function index() {
        $this->User->contain('UserGroup');

        $users = $this->paginate('User');
        $this->set(compact('users'));
    }

    public function edit($id) {
        if ($this->request->is('PUT') || $this->request->is('POST')) {
            if ($this->User->save($this->request->data)) {

                $flash = Configure::read('CakeUser.Flash.UserEdit');
                $msg = str_replace('%s', $this->User->field('username'), $flash['message']);
                $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

                $this->redirect(array('action' => 'index'));
            }
        }
        else {
            $user = $this->User->find('first', array(
                'conditions' => array('User.id' => $id),
                'contain' => 'UserGroup',
            ));

            if (!$user) {
                throw new NotFoundException(Configure::read('CakeUser.Exception.UserNotFound'));
            }

            $this->request->data = $user;
        }

        $userGroups = $this->User->UserGroup->find('list');
        $this->set(compact('userGroups'));
    }
    
    public function delete($id) {
        $user = $this->User->read(NULL, $id);
        
        if (!$user) {
            throw new NotFoundException(Configure::read('CakeUser.Exception.UserNotFound'));
        }
        
        if($this->User->delete($id)) {
            $flash = Configure::read('CakeUser.Flash.UserDelete');
            $msg = str_replace('%s', $user['User']['username'], $flash['message']);
            $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

            $this->redirect(array('action' => 'index'));
        }
    }

}
