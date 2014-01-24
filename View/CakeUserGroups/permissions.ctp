<h1><?php echo __('Change group\'s permissions') ?></h1>

<?php echo $this->Form->create() ?>
<?php echo $this->Form->input('Aro.id', array('type' => 'hidden', 'value' => $aro['Aro']['id'])) ?>
<ul>
    <?php 
    foreach ($acos as $aco): 
        echo $this->element('cake_user_aco_tree_element', array('aco' => $aco));
    endforeach; 
    ?>
</ul>

<?php
echo $this->Form->submit(__('Update permissions'));
echo $this->Form->end();