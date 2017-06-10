 <nav id="menu">
            <ul>
                <li><?php echo $this->Html->link('Home', array('plugin'=>false, 'controller'=>'pages', 'action'=>'home')); ?></li>
                <li><?php echo $this->Html->link('Empresa', array('plugin'=>false, 'controller'=>'public', 'action'=>'empresa')); ?></li>
                <li><?php echo $this->Html->link('Nossas lojas', array('plugin'=>false, 'controller'=>'public', 'action'=>'lojas')); ?></li>
                <li><?php echo $this->Html->link('Catálogo de profissionais', array('plugin'=>false, 'controller'=>'public', 'action'=>'profissionais')); ?></li>
                <li><?php echo $this->Html->link('Promoções', array('plugin'=>false, 'controller'=>'public', 'action'=>'promocoes')); ?></li>
                <li><?php echo $this->Html->link('Orçamento', array('plugin'=>false, 'controller'=>'public', 'action'=>'orcamento')); ?></li>
                <li><?php echo $this->Html->link('Contato', array('plugin'=>false, 'controller'=>'public', 'action'=>'contato')); ?></li>
            </ul>
</nav>