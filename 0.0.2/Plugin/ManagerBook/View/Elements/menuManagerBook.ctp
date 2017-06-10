    <?php $action = $this->action; ?>    
<br>    
<ul>
        <li><?php echo $this->Html->link(__('Home'), array('plugin'=>'manager_book', 'controller'=>'managerBooks', 'action' => 'index', $caderno)); ?></li>
                
        <li id="titleButtons">ARTIGOS</li>
        <?php if($action <> 'admin_pendingPosts'): ?>
        <li><?php echo $this->Html->link(__('Para análise'), array('controller'=>'managerBooks', 'action' => 'pendingPosts', $caderno)); ?></li>
        <?php endif; ?>
       
        <?php if($action <> 'admin_authorizedPosts'): ?>
        <li><?php echo $this->Html->link(__('Autorizados'), array('controller'=>'managerBooks', 'action' => 'authorizedPosts', $caderno)); ?></li>
        <?php endif; ?>
        
        <?php if($action <> 'admin_reprovedPosts'): ?>
        <li><?php echo $this->Html->link(__('Enviados para revisão'), array('controller'=>'managerBooks', 'action' => 'reprovedPosts', $caderno)); ?></li>
        <?php endif; ?>
        
        <li id="titleButtons">Categorias</li>
         <?php if($action <> 'admin_addCategorie'): ?>
        <li><?php echo $this->Html->link(__('Nova categoria'), array('controller'=>'managerBooks', 'action' => 'addCategorie', $caderno)); ?></li>
        <?php endif; ?>
       
        <?php if($action <> 'admin_listCategorie'): ?>
        <li><?php echo $this->Html->link(__('Listar categorias'), array('controller'=>'managerBooks', 'action' => 'listCategorie', $caderno)); ?></li>
        <?php endif; ?>
        
        <li id="titleButtons">Usuários</li>
        <?php if($action <> 'admin_listUsers'): ?>
        <li><?php echo $this->Html->link(__('Listar usuários'), array('controller'=>'managerUsers', 'action' => 'listUsers', $caderno)); ?></li>
        <?php endif; ?>
        
        <?php if($action <> 'admin_addUser'): ?>
        <li><?php echo $this->Html->link(__('Novo usuário'), array('controller'=>'managerUsers', 'action' => 'addUser', $caderno)); ?></li>
        <?php endif; ?>
        <li id="titleButtons">Novos colunistas</li>
        <?php if($action <> 'admin_requests'): ?>
        <li><?php echo $this->Html->link(__('Novas solicitações'), array('controller'=>'managerUsers', 'action' => 'requests', $caderno)); ?></li>
        <?php endif; ?>
        
         <?php if($action <> 'admin_outstanding'): ?>
        <li><?php echo $this->Html->link(__('Permissões pendentes'), array('controller'=>'managerUsers', 'action' => 'outstanding', $caderno)); ?></li>
        <?php endif; ?>
        
        
</ul> 