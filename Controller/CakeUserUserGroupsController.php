<?php

/**
 * @property UserGroup $UserGroup 
 */
class CakeUserUserGroupsController extends CakeUserAppController {

    public $uses = array('CakeUser.UserGroup');

    public function index() {
        $this->UserGroup->contain('ParentUserGroup');
        $groups = $this->paginate('UserGroup');

        $this->set(compact('groups'));
    }

    public function edit($id) {
        if ($this->request->is('PUT') || $this->request->is('POST')) {
            if ($this->UserGroup->save($this->request->data)) {

                $flash = Configure::read('CakeUser.Flash.UserGroupEdit');
                $msg = str_replace('%s', $this->UserGroup->field('title'), $flash['message']);
                $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

                $this->redirect(array('action' => 'index'));
            }
        }
        else {
            $userGroup = $this->UserGroup->find('first', array(
                'conditions' => array('UserGroup.id' => $id),
                'contain' => FALSE,
            ));

            if (!$userGroup) {
                throw new NotFoundException(Configure::read('CakeUser.Exception.UserGroupNotFound'));
            }

            $this->request->data = $userGroup;
        }

        $parents = $this->UserGroup->find('list', array(
            'conditions' => array(
                'id NOT' => $id,
                'parent_id' => NULL,
            )
        ));

        $this->set(compact('parents'));
    }

    public function add() {
        if ($this->request->is('POST')) {
            if ($this->UserGroup->save($this->request->data)) {
                $flash = Configure::read('CakeUser.Flash.UserGroupAdd');
                $msg = str_replace('%s', $this->UserGroup->field('title'), $flash['message']);
                $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

                $this->redirect(array('action' => 'index'));
            }
        }

        $parents = $this->UserGroup->find('list', array(
            'conditions' => array(
                'parent_id' => NULL,
            )
        ));

        $this->set(compact('parents'));
    }

    
    public function delete($id) {
        $userGroup = $this->UserGroup->read(NULL, $id);
        
        if (!$userGroup) {
            throw new NotFoundException(Configure::read('CakeUser.Exception.UserGroupNotFound'));
        }
        
        if($this->UserGroup->delete($id)) {
            $flash = Configure::read('CakeUser.Flash.UserGroupDelete');
            $msg = str_replace('%s', $userGroup['UserGroup']['title'], $flash['message']);
            $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

            $this->redirect(array('action' => 'index'));
        }
    }
}
