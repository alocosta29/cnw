<table cellpadding="5px" cellspacing="0" class="scrollQuebra" width="100%">
    <tr>
        <th></th>
        <th><?php echo $this->Paginator->sort('nome', 'Nome'); ?></th>
        <th><?php echo $this->Paginator->sort('area_id', 'Área pretendida'); ?></th>
        <th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>
        <th><?php echo $this->Paginator->sort('created', 'Data'); ?></th>
        <th><?php echo $this->Paginator->sort('arquivo_anexo', 'Currículo'); ?></th>
        <th>Ações</th>
    </tr>   
    <?php foreach ($Rhs as $variavel): ?>
   
     
   
   
    <?php if($variavel['Rh']['read'] == 'N'){ ?>
     
    <tr style="font-weight: bold; ">
        <td><?php echo $this->Html->image('mail.png'); ?></td>
        <td><?php echo $variavel['Rh']['nome']; ?></td>
        <td><?php echo $variavel['Area']['area']; ?></td>
        <td><?php echo $variavel['Rh']['email']; ?></td>
        <td><?php echo $this->Time->format('d/m/Y H:i', $variavel['Rh']['created']); ?></td>
        <td><?php echo $this->Html->link($variavel['Rh']['arquivo_anexo'], array('plugin'=>false, 'controller'=>'download', 'action'=>'getCv', 'admin'=>false,  $variavel['Rh']['id'])); ?></td>
        <td class="actions">
            <?php 
           // echo $this->Html->link($imageC, array('plugin'=>false, 'controller'=>'public', 'action'=>'abrirPasta', 'admin'=>false, $this->Complement->cryptDecrypt($category['CatArquivo']['id'], true)), array('escape'=>false));
            echo $this->AclLink->link(__('Abrir'), array('action' => 'openCv', $variavel['Rh']['id'])); ?>
           <?php /*echo $this->AclLink->postLink(__('Delete'), array('action' => 'delete', $variavel['Contato']['id']), 
           null, __('Tem certeza que deseja deletar o email de %s?', $variavel['Contato']['nome']));*/ ?>
        </td>
    </tr>

    <?php }else{ ?>
    
        <tr>
            <td><?php echo $this->Html->image('openmail.png'); ?></td>
        <td><?php echo $variavel['Rh']['nome']; ?></td>
        <td><?php echo $variavel['Area']['area']; ?></td>
        <td><?php echo $variavel['Rh']['email']; ?></td>
        <td><?php echo $this->Time->format('d/m/Y H:i', $variavel['Rh']['created']); ?></td>
        <td><?php echo $this->Html->link($variavel['Rh']['arquivo_anexo'], array('plugin'=>false, 'controller'=>'download', 'action'=>'getCv', 'admin'=>false,  $variavel['Rh']['id'])); ?></td>
        <td class="actions">
            <?php echo $this->AclLink->link(__('Abrir'), array('action' => 'openCv', $variavel['Rh']['id']));  ?>
           <?php /*echo $this->AclLink->postLink(__('Delete'), array('action' => 'delete', $variavel['Contato']['id']), 
           null, __('Tem certeza que deseja deletar o email de %s?', $variavel['Contato']['nome']));*/ ?>
        </td>
    </tr>
    
    
    
    
    <?php } ?>
<?php endforeach; ?>
</table>
<?php echo $this->element('paginacao'); ?>
