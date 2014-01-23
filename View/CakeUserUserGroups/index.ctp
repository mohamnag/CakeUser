<h1><?php echo __('List of all user groups') ?></h1>

<?php echo $this->Html->link(__('Create new group'), array('action'=>'add')) ?>

<table>
    <thead>
        <tr>
            <th colspan="3">
                <?php echo $this->Paginator->pager(); ?>
            </th>
        </tr>
        <tr>
            <th><?php echo __('Group name')?></th>
            <th><?php echo __('Parent')?></th>
            <th><?php echo __('Actions')?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="3">
                <?php echo $this->Paginator->pagination(array('ul' => 'pagination pagination-large')); ?>
            </td>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($groups as $group): ?>
        <tr>
            <td><?php echo $group['UserGroup']['title'] ?></td>
            <td><?php echo $group['ParentUserGroup']['title'] ?></td>
            <td>
                <?php
                echo $this->Html->link(
                        __('Delete'), 
                        array('action'=>'delete', $group['UserGroup']['id']), 
                        array('class'=>'btn btn-default btn-xs'),
                        __('Are you sure you want to delete group %s and all of its users?', $group['UserGroup']['title'])
                );
                ?>
                <?php
                echo $this->Html->link(__('Edit'), 
                        array('action'=>'edit', $group['UserGroup']['id']), 
                        array('class'=>'btn btn-default btn-xs')
                );
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>