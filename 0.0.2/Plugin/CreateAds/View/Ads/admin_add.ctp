<div class="assist">
    <?php echo $this->element('CreateAds.menuAds'); ?>
</div>
<div class="main">
    <?php echo $this->Form->create('Ad', array('class'=>'default2', 'type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Criar novo anúncio de imagem'); ?></legend>
	    <?php echo $this->Form->input('type_id', array('label'=>'Tipo', 'options'=>$listTypes)); ?>
        <?php echo $this->Form->input('link', array('label'=>'Link externo (exemplo: http://www.link.com.br)', 'placeholder'=>'http://www.suaurl.com.br')); ?>
        <?php echo $this->Form->input('imagem', array('type'=>'file')); ?>
        <?php echo $this->Form->input('data_inicio', 
                                    array(
                                            'label'=>'Início da veiculação',
                                            'dateFormat' => 'D/M/Y H:i',
                                            'timeFormat' => '24',
                                            'minYear' => date('Y') - 0,
                                            'maxYear' => date('Y') + 1 
                                          )); ?>
        <?php echo $this->Form->input('data_fim', 
                                            array(
                                                   'label'=>'Fim da veiculação',
                                                   'dateFormat' => 'D/M/Y H:i',
                                                   'timeFormat' => '24',
                                                   'minYear' => date('Y') - 0,
                                                   'maxYear' => date('Y') + 1 
                                                )); ?>
	<br>
    <?php echo $this->Form->end(__('Salvar')); ?>
    </fieldset>   
</div>