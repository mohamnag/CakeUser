<?php

/**
 * @property CakeUserGroup $CakeUserGroup 
 */
class CakeUserGroupsController extends CakeUserAppController {

    public $uses = array('CakeUser.CakeUserGroup');

    public function index() {
        $this->CakeUserGroup->contain('ParentCakeUserGroup');
        $groups = $this->paginate('CakeUserGroup');

        $this->set(compact('groups'));
    }

    public function edit($id) {
        if ($this->request->is('PUT') || $this->request->is('POST')) {
            if ($this->CakeUserGroup->save($this->request->data)) {

                $flash = Configure::read('CakeUser.Flash.CakeUserGroupEdit');
                $msg = str_replace('%s', $this->CakeUserGroup->field('title'), $flash['message']);
                $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

                $this->redirect(array('action' => 'index'));
            }
        }
        else {
            $userGroup = $this->CakeUserGroup->find('first', array(
                'conditions' => array('CakeUserGroup.id' => $id),
                'contain' => FALSE,
            ));

            if (!$userGroup) {
                throw new NotFoundException(Configure::read('CakeUser.Exception.CakeUserGroupNotFound'));
            }

            $this->request->data = $userGroup;
        }

        $parents = $this->CakeUserGroup->find('list', array(
            'conditions' => array(
                'id NOT' => $id,
                'parent_id' => NULL,
            )
        ));

        $this->set(compact('parents'));
    }

    public function add() {
        if ($this->request->is('POST')) {
            if ($this->CakeUserGroup->save($this->request->data)) {
                $flash = Configure::read('CakeUser.Flash.CakeUserGroupAdd');
                $msg = str_replace('%s', $this->CakeUserGroup->field('title'), $flash['message']);
                $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

                $this->redirect(array('action' => 'index'));
            }
        }

        $parents = $this->CakeUserGroup->find('list', array(
            'conditions' => array(
                'parent_id' => NULL,
            )
        ));

        $this->set(compact('parents'));
    }

    public function delete($id) {
        $userGroup = $this->CakeUserGroup->read(NULL, $id);

        if (!$userGroup) {
            throw new NotFoundException(Configure::read('CakeUser.Exception.CakeUserGroupNotFound'));
        }

        if ($this->CakeUserGroup->delete($id)) {
            $flash = Configure::read('CakeUser.Flash.CakeUserGroupDelete');
            $msg = str_replace('%s', $userGroup['CakeUserGroup']['title'], $flash['message']);
            $this->Session->setFlash($msg, $flash['element'], $flash['params'], $flash['key']);

            $this->redirect(array('action' => 'index'));
        }
    }

    public function permissions($id) {
        $aroCond = array(
            'model' => $this->CakeUserGroup->alias,
            'foreign_key' => $id,
        );

        if ($this->request->is('POST')) {
            if($this->Acl->Aro->saveAll($this->request->data)) {
                $flash = Configure::read('CakeUser.Flash.PermissionsUpdate');
                $this->Session->setFlash($flash['message'], $flash['element'], $flash['params'], $flash['key']);
            }
        }

        $this->Acl->Aro->Behaviors->load('Containable');
        $aro = $this->Acl->Aro->find('first', array(
            'conditions' => $aroCond,
            'contain' => FALSE
        ));

        $this->Acl->Aco->Behaviors->load('Containable');
        $acos = $this->Acl->Aco->find('threaded', array(
            'contain' => array('Aro' => array('conditions' => $aroCond))
        ));

        $this->set(compact('acos', 'aro'));
    }

}
