<h1><?php echo __('Create new user group')?></h1>

<?php
echo $this->Form->create();
echo $this->Form->input('title', array('label'=>__('Group title')));
echo $this->Form->input('parent_id', array('label'=>__('Parent group'), 'empty'=>__('- no parent')));
echo $this->Form->submit(__('Create'));
echo $this->Form->end();