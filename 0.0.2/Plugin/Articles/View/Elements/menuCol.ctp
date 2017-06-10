<br>
<ul>
    <li><?php echo $this->Html->link('Gerenciar meus artigos', array('action'=>'listPosts', $caderno)); ?></li>
    <li><?php echo $this->Html->link('Gerenciar meu perfil', array('controller'=>'profiles', 'action'=>'view', $caderno)); ?></li>
    <li><?php echo $this->Html->link('Baixar manual de colunista', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'getManual'), array('target'=>'_blank')); ?></li>
</ul>