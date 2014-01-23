<h1><?php echo __('List of all users') ?></h1>

<table>
    <thead>
        <tr>
            <th colspan="4">
                <?php echo $this->Paginator->pager(); ?>
            </th>
        </tr>
        <tr>
            <th><?php echo __('User name')?></th>
            <th><?php echo __('Status')?></th>
            <th><?php echo __('Group')?></th>
            <th><?php echo __('Actions')?></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="4">
                <?php echo $this->Paginator->pagination(array('ul' => 'pagination pagination-large')); ?>
            </td>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['User']['username'] ?></td>
            <td><?php echo $user['User']['is_active'] ? __('activated') : __('not activated') ?></td>
            <td><?php echo $user['UserGroup']['title'] ?></td>
            <td>
                <?php
                echo $this->Html->link(__('Delete'), 
                    array('action'=>'delete', $user['User']['id']), 
                    array('class'=>'btn btn-default btn-xs')
                );
                ?>
                <?php
                echo $this->Html->link(__('Edit'), 
                    array('action'=>'edit', $user['User']['id']), 
                    array('class'=>'btn btn-default btn-xs')
                );
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>