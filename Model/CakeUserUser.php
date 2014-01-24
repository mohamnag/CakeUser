<?php

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('CakeUserGroup', 'CakeUser.Model');

/**
 * @property CakeUserGroup $CakeUserGroup 
 */
class CakeUserUser extends CakeUserAppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';
    public $belongsTo = array(
        'CakeUserGroup' => array(
            'className' => 'CakeUser.CakeUserGroup',
        ),
    );
    public $actsAs = array('Acl' => array(
            'type' => 'requester',
    ));

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return NULL;
        }

        if (isset($this->data[$this->alias]['cake_user_group_id'])) {
            $groupId = $this->data[$this->alias]['cake_user_group_id'];
        }
        else {
            $groupId = $this->field('cake_user_group_id');
        }

        if (!$groupId) {
            return NULL;
        }
        else {
            return array(
                $this->CakeUserGroup->alias => array(
                    $this->CakeUserGroup->primaryKey => $groupId
                )
            );
        }
    }

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);

        $prefixcfg = Configure::read('CakeUser.TablePrefix');
        if (!empty($dbcfg)) {
            $this->tablePrefix = $prefixcfg;
        }

        $this->validate = array(
            'username' => array(
                'rule' => array('shouldNotExists'),
                'message' => Configure::read('CakeUser.Validation.CakeUserUser.DuplicateUsername'),
                'on' => 'create'
            ),
            'password' => array(
                'rule' => array('minLength', '8'),
                'message' => Configure::read('CakeUser.Validation.CakeUserUser.ShortPassword'),
            ),
            'password2' => array(
                'rule' => array('matchField', 'password'),
                'message' => Configure::read('CakeUser.Validation.CakeUserUser.PasswordsNotMatch'),
            ),
        );
    }

    public function beforeSave($options = array()) {
        $id = !isset($this->data[$this->alias][$this->primaryKey]) ? $this->id : $this->data[$this->alias][$this->primaryKey];
        if (empty($id)) {
            $this->data[$this->alias]['is_active'] = FALSE;

            if (!isset($this->data[$this->alias]['cake_user_group_id'])) {
                $this->data[$this->alias]['cake_user_group_id'] = CakeUserGroup::DEFAULT_GROUP_ID;
            }
        }

        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }

        return parent::beforeSave($options);
    }

}
