<div class="assist">
    <br>
    <ul>
    <?php echo '<li>'.$this->Html->link('Editar', array('action'=>'editDescricaoInstitucional')).'</li>'; ?>
    </ul>
</div>
<div class="main">
    <h2>Descrição institucional</h2>
<?php if(!empty($quemSomos)){
    echo '<strong>TÍTULO</strong><br>'.$quemSomos['Postagen']['titulo'].'<br><br>';
    echo '<strong>RESUMO</strong><br>'.$quemSomos['Postagen']['resumo'].'<br><br>';
    echo '<strong>TEXTO</strong><br>'.$quemSomos['Postagen']['texto'].'<br><br>';    
    ?>
<div style="clear: both; "></div>
<?php }else{ ?>
<span style="font-weight: bold; ">Não existe descrição institucional. Por favor, acesse o menu Conteúdo -> Editar descrição institucional e cadastre uma!</span>
<?php } ?>

</div>