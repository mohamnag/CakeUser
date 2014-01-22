<?php

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('UserGroup', 'CakeUser.Model');

/**
 * @property UserGroup $UserGroup 
 */
class User extends CakeUserAppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';
    public $belongsTo = array(
        'UserGroup' => array(
            'className' => 'CakeUser.UserGroup',
        ),
    );
    public $actsAs = array('Acl' => array(
            'type' => 'requester',
    ));

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return NULL;
        }

        if (isset($this->data[$this->alias]['user_group_id'])) {
            $groupId = $this->data[$this->alias]['user_group_id'];
        }
        else {
            $groupId = $this->field('user_group_id');
        }

        if (!$groupId) {
            return NULL;
        }
        else {
            return array(
                $this->UserGroup->alias => array(
                    $this->UserGroup->primaryKey => $groupId
                )
            );
        }
    }

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

        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }

        return parent::beforeSave($options);
    }

}
