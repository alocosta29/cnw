
<div class="main">
<?php echo $this->Form->create('User', array('class' => 'default2'));?>
	<fieldset>
	
		<legend><?php echo __('Formulário para troca de senha'); ?></legend>
		<?php
		echo $this->Form->input('id', array('label' => 'Id:','value' => $id));
		echo $this->Form->input('namex', array('readOnly'=>'','label' => 'Nome:', 'value' => $nome));
		echo $this->Form->input('senhaAntiga', array('type' => 'password', 'label' => 'Senha Atual:'));
		echo $this->Form->input('newPassword', array('type' => 'password', 'label' => 'Senha Nova:'));
		echo $this->Form->input('confirmPassword', array('type' => 'password', 'label' => 'Confirme a Senha Nova:'));
		echo $this->Form->input('password', array('type' => 'hidden'));
		echo $this->Form->end(__('Alterar senha'));
		?>
	</fieldset>
</div>

