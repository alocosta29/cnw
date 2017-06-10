
<div class="main" style="width: 620px">
	<h2><?php  echo __('Usuário');?></h2>
	<dl>
		<dt><?php echo __('Id:'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nome:'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pessoa:'); ?></dt>
		<dd>
			<?php echo ($user['Person']['tipo_pessoa']==='J')?($user['Person']['Companie']['0']['r_social']):$user['Person']['Individual']['0']['nome'];?>
			&nbsp;
		</dd>
		<dt><?php echo ($user['Person']['tipo_pessoa']==='J')?'CNPJ:':'CPF'; ?></dt>
		<dd>
			<?php echo ($user['Person']['tipo_pessoa']==='J')?($user['Person']['Companie']['0']['cnpj']):$user['Person']['Individual']['0']['cpf'];?>
			&nbsp;
		</dd>
		<?php foreach ($user['Person']['Contact'] as $contatos): 
			if( (strlen(trim($contatos['contato']))>0) or (strlen(trim($contatos['pessoa_paracontato']))>0) ): 
			?>
			<dt><?php echo $contatos['Contactstype']['label'].':'; ?></dt>
			<dd>
				<?php echo h($contatos['contato']); echo (strlen(trim($contatos['pessoa_paracontato']))>0)? ' ('.h($contatos['pessoa_paracontato']).')':''; ?>
				&nbsp;
			</dd>
		<?php 
			endif; 
		endforeach; 
		?>
		<dt><?php echo __('Papeis:'); ?></dt>
		<dd>
			<?php
			foreach ($user['Role'] as $roles) {
				echo $roles['alias'].' ';
			} 
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('Criado em:'); ?></dt>
		<dd>
			<?php if(strlen(trim($user['User']['created']))>0):echo date('d/m/Y H:i', strtotime("+0 days",strtotime($user['User']['created'])));endif;?>
			&nbsp;
		</dd>
		<dt><?php echo __('Criado por:'); ?></dt>
		<dd>
			<?php if(isset($user['UserCreated']['username'])):echo h($user['UserCreated']['username']);endif; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado em:'); ?></dt>
		<dd>
			<?php if(strlen(trim($user['User']['modified']))>0):echo date('d/m/Y H:i', strtotime("+0 days",strtotime($user['User']['modified'])));endif;?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modificado por:'); ?></dt>
		<dd>
			<?php if(isset($user['UserModified']['username'])):echo h($user['UserModified']['username']);endif; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Usuario ativado?'); ?></dt>
		<dd>
			<?php echo h($user['User']['isactive']); ?>
			&nbsp;
		</dd>

	</dl>
</div>

