<h1><?php echo __('Edit user')?></h1>

<?php
echo $this->Form->create();
echo $this->Form->input('id');
echo $this->Form->input('username', array('label'=>__('User name')));
echo $this->Form->input('is_active', array('label'=>__('Activated')));
echo $this->Form->input('user_group_id', array('label'=>__('Group')));
echo $this->Form->submit(__('Update'));
echo $this->Form->end();