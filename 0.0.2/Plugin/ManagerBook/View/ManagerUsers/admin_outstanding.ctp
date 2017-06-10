<div class="assist">
<?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>
<div class="main">
    <h2><?php echo $this->ReturnData->getBook($caderno).': ';   ?>Permissões pendentes </h2>	
    
    <table cellpadding="5px" cellspacing="0" class="scroll" width="100%">
	<tr>
		<th><?php echo $this->Paginator->sort('nome', 'Nome'); ?></th>
                <th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>
                <th>Ações</th>
	</tr>	
	<?php foreach ($reports as $report): ?>
	<tr>
		<td><?php echo h($report['Cadastro']['nome']); ?></td>
                <td><?php echo h($report['Cadastro']['email']); ?></td>
		<td class="actions">
                        <?php
                        
                        echo $this->Form->postLink(__('Autorizar acesso'), array('action' => 'allowOutstanding', $caderno, $report['CadastrosCaderno']['id']), null, __('Tem certeza que deseja autorizar a permissão de acesso pendente ?', null));
                        
                        echo $this->Form->postLink(__('Negar acesso'), array('action' => 'denyOutstanding', $caderno, $report['CadastrosCaderno']['id']), null, __('Tem certeza que deseja negar a permissão de acesso pendente?', null));
                        
                        ?>
                        
                        
		</td>
	</tr>
<?php endforeach; ?>
        </table>
    <?php echo $this->Element('paginacao'); ?>
</div>
    
    
    
    
