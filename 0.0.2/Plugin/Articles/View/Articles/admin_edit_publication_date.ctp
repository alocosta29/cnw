<div class="main">
    <h2>Alterar data de publicação</h2>
    <strong>Artigo: </strong><?php echo $dataArtigo['titulo']; ?>
    <?php echo $this->Form->create('Artigo', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Editar data de publicação'); ?></legend>
                <?php echo $this->Form->input(
                                                'data_publicacao', array( 'label' => 'Data/hora de publicação',
                                                'dateFormat' => 'D/M/Y H:i',
                                                'timeFormat' => '24',
                                                'minYear' => date('Y') - 0,
                                                'maxYear' => date('Y') + 1 )
                                             );  ?>
        <br>
    <?php echo $this->Form->end(__('Atualizar')); ?>
    </fieldset>
    <br>
    <?php
      $imagem = $this->Html->image('voltar.png');
      echo $this->Html->link($imagem, array('action'=>'view', $caderno, $dataArtigo['id']), array('escape'=>false));
    ?>
</div>   