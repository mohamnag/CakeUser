<li>
    <?php
    echo $this->Form->input('Aco.Aco.' . $aco['Aco']['id'] . '.aco_id', array(
        'hiddenField' => FALSE,
        'type' => 'checkbox',
        'value' => $aco['Aco']['id'],
        'label' => $aco['Aco']['alias'],
        'checked' => !empty($aco['Aro']),
    ));
    echo $this->Form->input('Aco.Aco.' . $aco['Aco']['id'] . '._create', array(
        'type' => 'checkbox', 'value' => TRUE, 'label' => __('C'), 'checked' => !empty($aco['Aro']) ? $aco['Aro'][0]['Permission']['_create'] : FALSE,
    ));
    echo $this->Form->input('Aco.Aco.' . $aco['Aco']['id'] . '._read', array(
        'type' => 'checkbox', 'value' => TRUE, 'label' => __('R'), 'checked' => !empty($aco['Aro']) ? $aco['Aro'][0]['Permission']['_read'] : FALSE,
    ));
    echo $this->Form->input('Aco.Aco.' . $aco['Aco']['id'] . '._update', array(
        'type' => 'checkbox', 'value' => TRUE, 'label' => __('U'), 'checked' => !empty($aco['Aro']) ? $aco['Aro'][0]['Permission']['_update'] : FALSE,
    ));
    echo $this->Form->input('Aco.Aco.' . $aco['Aco']['id'] . '._delete', array(
        'type' => 'checkbox', 'value' => TRUE, 'label' => __('D'), 'checked' => !empty($aco['Aro']) ? $aco['Aro'][0]['Permission']['_delete'] : FALSE,
    ));
    ?>
    <?php if (!empty($aco['children'])): ?>
        <ul>
            <?php foreach ($aco['children'] as $aco): ?>
                <?php echo $this->element('cake_user_aco_tree_element', array('aco' => $aco)) ?>
            <?php endforeach; ?>
        </ul>
    <?php endif ?>
</li>