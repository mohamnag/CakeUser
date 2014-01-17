
<div class="col-md-8 col-md-offset-2">

    <?php echo $this->Session->flash('auth'); ?>

    <?php
    echo $this->Form->create(array('class' => 'well'));
    echo $this->Form->input('username', array('label' => __('User name')));
    echo $this->Form->input('password', array('label' => __('Password')));
    echo $this->Form->submit('Login');
    echo $this->Form->end();
    ?>
</div>
