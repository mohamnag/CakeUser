<?php

class CakeUserAppModel extends AppModel {

    public $actsAs = array('Containable');

    public function matchField($check, $otherField) {
        $val = reset($check);
        return $val == $this->data[$this->alias][$otherField];
    }

    public function shouldNotExists($check) {
        return $this->limitDuplicates($check, 1);
    }

    public function limitDuplicates($check, $limit) {
        $existing_count = $this->find('count', array(
            'conditions' => $check,
            'recursive' => -1
        ));
        return $existing_count < $limit;
    }

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);

        $this->setDataSource(Configure::read('CakeUser.DbConfig'));
    }

}
