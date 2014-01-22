<h1><?php echo __('Log in')?></h1>

<div>

    <?php echo $this->Session->flash('auth'); ?>

    <?php
    echo $this->Form->create();
    echo $this->Form->input('username', array('label' => __('User name')));
    echo $this->Form->input('password', array('label' => __('Password')));
    echo $this->Form->submit(__('Log in'));
    echo $this->Form->end();
    ?>
</div>
