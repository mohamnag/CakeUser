<?php

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('UserGroup', 'CakeUser.Model');

/**
 * @property UserGroup $UserGroup 
 * @property Aro $Aro 
 */
class User extends CakeUserAppModel {

    public $belongsTo = array(
        'UserGroup' => array(
            'className' => 'CakeUser.UserGroup',
        ),
    );
    public $hasOne = array(
        'Aro' => array(
            'className' => 'Aro',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);

        $dbcfg = Configure::read('CakeUser.DbConfig');
        if (!empty($dbcfg)) {
            $this->useDbConfig = $dbcfg;
        }

        $prefixcfg = Configure::read('CakeUser.TablePrefix');
        if (!empty($dbcfg)) {
            $this->tablePrefix = $prefixcfg;
        }

        $this->validate = array(
            'username' => array(
                'rule' => array('shouldNotExists'),
                'message' => Configure::read('CakeUser.Validation.User.DuplicateUsername'),
                'on' => 'create'
            ),
            'password' => array(
                'rule' => array('minLength', '8'),
                'message' => Configure::read('CakeUser.Validation.User.ShortPassword'),
            ),
            'password2' => array(
                'rule' => array('matchField', 'password'),
                'message' => Configure::read('CakeUser.Validation.User.PasswordsNotMatch'),
            ),
        );
    }

    public function beforeSave($options = array()) {
        $id = !isset($this->data[$this->alias][$this->primaryKey]) ? $this->id : $this->data[$this->alias][$this->primaryKey];
        if (empty($id)) {
            $this->data[$this->alias]['is_active'] = FALSE;

            if (!isset($this->data[$this->alias]['user_group_id'])) {
                $this->data[$this->alias]['user_group_id'] = UserGroup::DEFAULT_GROUP_ID;
            }
        }
        else if (isset($this->data[$this->alias]['user_group_id'])) {
            //if user's group changes, we have to update its Aro
            //TODO: will it work?? if save is not saveAssociated
            $oldData = $this->find('first', array(
                'conditions' => array('id' => $id),
                'contain' => 'Aro'
            ));

            if ($oldData[$this->alias]['user_group_id'] !== $this->data[$this->alias]['user_group_id']) {
                $this->data['Aro'] = array(
                    'id' => $oldData['Aro']['id'],
                    'parent_id' => $this->Aro->field('id', array(
                        'model' => $this->UserGroup->alias,
                        'foreign_key' => $this->data[$this->alias]['user_group_id']
                    ))
                );
            }
        }

        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }

        return parent::beforeSave($options);
    }

    public function afterSave($created, $options = array()) {
        if ($created) {
            //create the Aro for this user and assign it the correct parent
            $this->Aro->create();
            $this->Aro->save(array(
                'Aro' => array(
                    'parent_id' => $this->Aro->field('id', array(
                        'model' => $this->UserGroup->alias,
                        'foreign_key' => $this->data[$this->alias]['user_group_id']
                    )),
                    'model' => $this->alias,
                    'foreign_key' => $this->id,
                    'alias' => $this->data[$this->alias]['username'],
                )
            ));
        }
        
        parent::afterSave($created, $options);
    }

}
