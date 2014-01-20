<?php

App::uses('AppModel', 'Model');

/**
 * UserGroup Model
 *
 * @property User $User
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
            'counterQuery' => ''
        )
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

    public function beforeSave($options = array()) {
        $id = !isset($this->data[$this->alias][$this->primaryKey]) ? $this->id : $this->data[$this->alias][$this->primaryKey];
        if (!empty($id) && isset($this->data[$this->alias]['parent_id'])) {
            //if group's parent changes, we have to update its Aro
            //TODO: will it work?? if save is not saveAssociated
            $oldData = $this->find('first', array(
                'conditions' => array('id' => $id),
                'contain' => 'Aro'
            ));

            if ($oldData[$this->alias]['user_group_id'] !== $this->data[$this->alias]['user_group_id']) {
                $this->data['Aro'] = array(
                    'id' => $oldData['Aro']['id'],
                    'parent_id' => $this->Aro->field('id', array(
                        'model' => 'UserGroup',
                        'foreign_key' => $this->data[$this->alias]['user_group_id']
                    ))
                );
            }
        }

        parent::beforeSave($options);
    }

    public function afterSave($created, $options = array()) {
        if ($created) {
            //create the Aro for this group and assign it the correct parent
            if (!empty($this->data[$this->alias]['parent_id'])) {
                $this->data['Aro'] = array(
                    'parent_id' => $this->Aro->field('id', array(
                        'model' => 'UserGroup',
                        'foreign_key' => $this->data[$this->alias]['user_group_id']
                    )),
                    'model' => $this->alias,
                    'foreign_key' => $this->id,
                    'alias' => $this->data[$this->alias]['title'],
                );
            }
            else {
                $this->data['Aro'] = array(
                    'model' => $this->alias,
                    'foreign_key' => $this->id,
                    'alias' => $this->data[$this->alias]['title'],
                );
            }
        }
        parent::afterSave($created, $options);
    }

}
