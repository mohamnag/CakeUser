<?php

App::uses('AppModel', 'Model');

/**
 * UserGroup Model
 *
 * @property User $User
 * @property UserGroup $ParentUserGroup 
 */
class UserGroup extends CakeUserAppModel {

    const DEFAULT_GROUP_ID = 1;

    public $belongsTo = array(
        'ParentUserGroup' => array(
            'className' => 'CakeUser.UserGroup',
            'foreignKey' => 'parent_id',
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
            'counterQuery' => '',
        )
    );
    public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return NULL;
        }

        if (isset($this->data[$this->alias]['parent_id'])) {
            $parentId = $this->data[$this->alias]['parent_id'];
        }
        else {
            $parentId = $this->field('parent_id');
        }

        if (!$parentId) {
            return NULL;
        }
        else {
            return array(
                $this->ParentUserGroup->alias => array(
                    $this->ParentUserGroup->primaryKey => $parentId
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
}
