<?php

/**
 * @property CakeUserUser $CakeUserUser 
 */
class CakeUserUsersController extends CakeUserAppController {

    public $uses = array('CakeUser.CakeUserUser');

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
            if ($this->CakeUserUser->save($this->request->data)) {
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
        $this->CakeUserUser->contain('CakeUserGroup');

        $users = $this->paginate('CakeUserUser');
        $this->set(compact('users'));
    }

    public function edit($id) {
        if ($this->request->is('PUT') || $this->request->is('POST')) {
            if ($this->CakeUserUser->save($this->request->data)) {

                $flash = Configure::read('CakeUser.Flash.CakeUserUserEdit');
                $msg = str_replace('%s', $this->CakeUserUser->field('username'), $flash['message']);
                $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

                $this->redirect(array('action' => 'index'));
            }
        }
        else {
            $user = $this->CakeUserUser->find('first', array(
                'conditions' => array('CakeUserUser.id' => $id),
                'contain' => 'CakeUserGroup',
            ));

            if (!$user) {
                throw new NotFoundException(Configure::read('CakeUser.Exception.CakeUserUserNotFound'));
            }

            $this->request->data = $user;
        }

        $cakeUserGroups = $this->CakeUserUser->CakeUserGroup->find('list');
        $this->set(compact('cakeUserGroups'));
    }
    
    public function delete($id) {
        $user = $this->CakeUserUser->read(NULL, $id);
        
        if (!$user) {
            throw new NotFoundException(Configure::read('CakeUser.Exception.CakeUserUserNotFound'));
        }
        
        if($this->CakeUserUser->delete($id)) {
            $flash = Configure::read('CakeUser.Flash.CakeUserUserDelete');
            $msg = str_replace('%s', $user['CakeUserUser']['username'], $flash['message']);
            $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

            $this->redirect(array('action' => 'index'));
        }
    }

}
