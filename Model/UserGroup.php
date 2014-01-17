<?php

App::uses('AppModel', 'Model');

/**
 * UserGroup Model
 *
 * @property User $User
 */
class UserGroup extends CakeUserAppModel {

    const DEFAULT_GROUP_ID = 1;

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        
        $dbcfg = Configure::read('CakeUser.DbConfig');
        if(!empty($dbcfg)) {
            $this->useDbConfig = $dbcfg;
        }
        
        $this->validate = array(
            'title' => array(
                'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'message' => Configure::read('CakeUser.Validation.UserGroup.EmptyTitle'),
                ),
                'maxLength' => array(
                    'rule' => array('maxLength', 100),
                    'message' => Configure::read('CakeUser.Validation.UserGroup.LongTitle'),
                ),
            ),
        );
    }
    
    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'User' => array(
            'className' => 'CakeUser.User',
            'foreignKey' => 'user_group_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

}
