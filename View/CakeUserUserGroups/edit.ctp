<h1><?php echo __('Edit user group')?></h1>

<?php
echo $this->Form->create();
echo $this->Form->input('id');
echo $this->Form->input('title', array('label'=>__('Group title')));
echo $this->Form->input('parent_id', array('label'=>__('Parent group'), 'empty'=>__('- no parent')));
echo $this->Form->submit(__('Update'));
echo $this->Form->end();