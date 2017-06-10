<div class="client-list">
<div id="client-title">EMPRESAS ATENDIDAS</div>
<div id="client-itens">
<ul class="clients">
        <?php 
           if(!empty($listLogos)):
           foreach($listLogos as $project):
        ?>
        <li><?php echo $this->Html->image('clients_thumb/'.$project['Projeto']['imagem'], array('alt'=>$project['Projeto']['projeto'])); ?></li>
        <?php 
            endforeach;
            endif; 
        ?>
</ul>
</div>
</div>