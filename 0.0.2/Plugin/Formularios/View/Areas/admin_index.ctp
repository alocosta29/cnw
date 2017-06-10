<table cellpadding="5px" cellspacing="0" class="scrollQuebra" width="100%">
    <tr>
        <th><?php echo $this->Paginator->sort('area', 'Setor'); ?></th>
        <th>Ações</th>
    </tr>   
    <?php foreach ($Areas as $area): ?>
    <tr>
        <td><?php echo $area['Area']['area']; ?></td>
        <td class="actions">
            <?php echo $this->AclLink->link(__('Edit'), array('action' => 'edit', $area['Area']['id'])); ?>
            <?php echo $this->AclLink->postLink(__('Delete'), array('action' => 'delete', $area['Area']['id']), null, __('Tem certeza que deseja deletar %s?', $area['Area']['area'])); ?>
        </td>
    </tr>
<?php endforeach; ?>