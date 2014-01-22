<h1><?php echo __('List of all users') ?></h1>

<table>
    <thead>
        <tr>
            <th colspan="3">
                <?php echo $this->Paginator->pager(); ?>
            </th>
        </tr>
        <tr>
            <th><?php echo __('User name')?></th>
            <th><?php echo __('Status')?></th>
            <th><?php echo __('Group')?></th>
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
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['User']['username'] ?></td>
            <td><?php echo $user['User']['is_active'] ? __('activated') : __('not activated') ?></td>
            <td><?php echo $user['UserGroup']['title'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>