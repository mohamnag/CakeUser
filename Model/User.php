<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('UserGroup', 'CakeUser.Model');

/**
 * @property UserGroup $UserGroup 
 */
class User extends CakeUserAppModel {
    
    public $belongsTo = array(
        'UserGroup' => array(
            'className' => 'CakeUser.UserGroup',
        ),
    );
    
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
    
        $dbcfg = Configure::read('CakeUser.DbConfig');
        if(!empty($dbcfg)) {
            $this->useDbConfig = $dbcfg;
        }
        
        $this->validate = array(
            'username' => array(
                'rule'    => array('shouldNotExists'),
                'message' => Configure::read('CakeUser.Validation.User.DuplicateUsername'),
                'on' => 'create'
            ),
            'password' => array(
                'rule'    => array('minLength', '8'),
                'message' => Configure::read('CakeUser.Validation.User.ShortPassword'),
            ),
            'password2' => array(
                'rule'    => array('matchField', 'password'),
                'message' => Configure::read('CakeUser.Validation.User.PasswordsNotMatch'),
            ),
        );
    }
    
    public function beforeSave($options = array()) {
        if(empty($this->id) && !isset($this->data[$this->alias][$this->primaryKey])) {
            $this->data[$this->alias]['is_active'] = FALSE;
            
            if(!isset($this->data[$this->alias]['asui_user_group_id'])) {
                $this->data[$this->alias]['asui_user_group_id'] = UserGroup::DEFAULT_GROUP_ID;
            }
        }
        
        if(isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        
        return parent::beforeSave($options);
    }
}