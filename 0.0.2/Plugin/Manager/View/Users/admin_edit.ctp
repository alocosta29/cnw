<div class="main">
<?php echo $this->Form->create('User', array('class' => 'default2'));?>
	<fieldset>
	
		<legend><?php echo __('Editar Usuário'); ?></legend>
		<input type="hidden" name="data[User][roleAtual]" value="<?php echo $rolesAntigo ?>" >
		<?php
		echo $this->Form->hidden('User.id');
		echo $this->Form->hidden('Person.id');
		echo $this->Form->hidden('Person.tipo_pessoa');
		if($this->request->data['Person']['tipo_pessoa']==='J'):
			echo $this->Form->hidden('Person.Companie.0.id');
			echo $this->Form->input('Person.Companie.0.r_social', array('label' => 'Nome:'));
		else:
			echo $this->Form->hidden('Person.Individual.0.id');
			echo $this->Form->input('Person.Individual.0.nome', array('label' => 'Nome:'));
		endif;
		echo $this->Form->input('User.username', array('label' => 'Login:'));
		if( isset($this->request->data['Role']['0']['id']) ):
			if( $this->request->data['Role']['0']['id'] !== '1' ): #NaoGrupoSuperuser
				echo $this->Form->input('Role.0', array('options'=> $roles, 'label' => 'Grupo:'));
			else: #grupoSuperuser
				echo '<label for="Rolexsu">Grupo:</label>';
				echo '<b>&nbsp;&nbsp;&nbsp;'.strtoupper($this->request->data['Role']['0']['alias']).'</b><br>';
			endif;
		else: #semGrupo
			echo $this->Form->input('Role.0', array('options'=> $roles, 'label' => 'Grupo:'));
		endif;	
		?>
		
		<br/>
		<legend><?php echo __('Obs.: <br/> (1) Para alterar a senha é preciso informar ambos os campos.<br/> (2) Se não deseja trocar a senha, deixe os campos em branco.'); ?></legend>
		<?php
		echo $this->Form->input('newPassword', array('type' => 'password', 'label' => 'Senha Nova:','required'=>false));
		echo $this->Form->input('confirmPassword', array('type' => 'password', 'label' => 'Confirme a Senha Nova:','required'=>false));
		?><br><fieldset><legend>Contatos</legend>
		<table>	
			<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contato</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome do contato</td></tr>
		  <?php 

                  foreach($this->request->data['Person']['Contact'] as $key => $value): ?>
			
 			  <tr>
				<td>
				<?php
				echo $this->Form->hidden('Person.Contact.'.$key.'.id');
				echo $this->Form->input('Person.Contact.'.$key.'.contactstype_id', array('options'=> $contactstypes, 'label'=>''));
				echo '</td><td>';
				echo $this->Form->input('Person.Contact.'.$key.'.contato', array('label' => ''));
				echo '</td><td>';
				echo $this->Form->input('Person.Contact.'.$key.'.pessoa_paracontato', array('label' =>''));
				?>
				</td>	
			  </tr>
		  <?php endforeach; ?>
 			  <tr>
				<td>
				<?php
				if(!isset($key)) $key = 0;
				echo $this->Form->input('Person.Contact.'.($key+1).'.contactstype_id', array('options'=> $contactstypes, 'label'=>''));
				echo '</td><td>';
				echo $this->Form->input('Person.Contact.'.($key+1).'.contato', array('label' => ''));
				echo '</td><td>';
				echo $this->Form->input('Person.Contact.'.($key+1).'.pessoa_paracontato', array('label' =>''));
				?>
				</td>	
			  </tr>
		</table> 			
		</fieldset><?php
		echo $this->Form->end(__('Salvar'));
		?>
	</fieldset>
</div>
