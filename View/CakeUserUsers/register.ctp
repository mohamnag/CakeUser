<h1><?php echo __('Register a new user')?></h1>

<div>

    <?php echo $this->Session->flash('auth'); ?>

    <?php
    echo $this->Form->create();
    echo $this->Form->input('username', array('label' => __('User name')));
    echo $this->Form->input('password', array('label' => __('Password')));
    echo $this->Form->input('password2', array('type' => 'password', 'label' => __('Repeat password')));
    echo $this->Form->submit(__('Register'));
    echo $this->Form->end();
    ?>
</div>
