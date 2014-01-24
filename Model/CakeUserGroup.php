<?php

App::uses('AppModel', 'Model');

/**
 * CakeUserGroup Model
 *
 * @property CakeUserUser $CakeUserUser
 * @property CakeUserGroup $ParentCakeUserGroup 
 */
class CakeUserGroup extends CakeUserAppModel {

    const DEFAULT_GROUP_ID = 1;

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';
    public $belongsTo = array(
        'ParentCakeUserGroup' => array(
            'className' => 'CakeUser.CakeUserGroup',
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
        'CakeUserUser' => array(
            'className' => 'CakeUser.CakeUserUser',
            'foreignKey' => 'cake_user_group_id',
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
                $this->alias => array(
                    $this->ParentCakeUserGroup->primaryKey => $parentId
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
            'title' => array(
                'notEmpty' => array(
                    'rule' => array('notEmpty'),
                    'message' => Configure::read('CakeUser.Validation.CakeUserGroup.EmptyTitle'),
                ),
                'maxLength' => array(
                    'rule' => array('maxLength', 100),
                    'message' => Configure::read('CakeUser.Validation.CakeUserGroup.LongTitle'),
                ),
            ),
        );
    }

}
