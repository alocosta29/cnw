<?php echo $this->Html->script('Layout.jquery.stringToSlug.js'); ?>
<script>
$(document).ready( function() {
		$("#apelido").stringToSlug({
			setEvents: 'keyup keydown blur',
			getPut: '#slug',
			space: '-'
		});
	});
</script>
<div class="assist">
	<?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>

<div class="main">
    <h2><?php echo $this->ReturnData->getBook($caderno);   ?> </h2>	
<?php echo $this->Form->create('Person', array('class'=>'default2')); ?>
	<fieldset>
		<legend><?php echo __('Cadastro de colunistas'); ?></legend>
     <?php 
     $cpf = $this->Complement->mask($this->Session->read('Auth.User.addUser'),'###.###.###-##');
     echo $this->Form->input('Individual.0.cpf', array('default'=>$cpf, 'readonly'=>'readonly', 'label'=>'CPF')); ?>
     <?php echo $this->Form->input('User.0.username', array('label'=>'E-mail de login', 'default'=>$username)); ?>
     <?php echo $this->Form->input('Individual.0.nome', array('label'=>'Nome completo', 'default'=>$nome)); ?>
     <?php echo $this->Form->input('Colunista.0.apelido', array('id'=>'apelido')); ?>
        <?php echo $this->Form->input('Colunista.0.alias', array('id'=>'slug')); ?>
     <?php echo $this->Form->input('Individual.0.data_nascimento', array(
                                                		'label'=>'Data de nascimento',
                                                		'type'=>'date',
                                                        'timeFormat' => '24',
                                                        'dateFormat' => 'DMY',
                                                        'minYear' => date('Y') - 90,
                                                        'maxYear' => date('Y') + 2 
                                                		));?>
     <br>
     <?php echo $this->Form->end(__('Salvar')); ?>
     </fieldset>
</div>      