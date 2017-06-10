<?php if(!empty($extras)): ?>
<br>
<span style="font-weight: bold; color: <?php echo $selectColor; ?>;">MATERIAIS EXTRAS</span>
<ul>
<?php foreach($extras as $extra): ?>
<?php 
$name = $extra['nome'].' - '.$extra['descricao'];
echo '<li style = "list-style: none; ">'.$this->Html->image('extra_icons/'.
        $this->Complement->getIconExtra($extra['tipo_arquivo']), array('style'=>'max-width: 30px; float: left; margin-right: 10px; ')).$this->Html->link($name, $caderno['url_form'], array('target'=>'_blank')).'</li>'; ?>

<?php endforeach; ?>
    </ul>
<br>
<?php endif; ?>