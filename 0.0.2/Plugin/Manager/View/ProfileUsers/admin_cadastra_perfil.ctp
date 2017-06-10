<div class="main">	
<?php echo $this->Html->script(array('Manager.mask2', 'Manager.jquery.validate')); ?>
		 <style type="text/css">			
			span#loading {display: none;}
		</style>
		<?php 
		$hostCep = HOST_REAL.'manager/cepEnderecos/ajaxMsg?cep='; 
		if(isset($this->params['cpf'])){
			$cpf = $this->params['cpf'];
		}else{
			$cpf = '';
		}
		
		
		?>
<script type="text/javascript">
$(document).ready(function() {   
	$('#cep').keyup(function()
					{
					if ($(this).val().length == 5)
					{
						$(this).attr('value', $(this).val() + '-');
					};
					});
		          
            $("#cep").blur(function() {   
            	var cep1 = $("#cep").val();            
                    $.getJSON(
                        "<?php echo $hostCep; ?>" + cep1,
                        null,
                        function(data) {   
                        	                                              		
                           // $("#msg").html(data);
                            //alert(data.logradouro);
                            $('#logradouro').attr('value', data.logradouro);
                             $('#uf').attr('value', data.uf);
                            $('#cidade').attr('value', data.cidade);
                            $('#nomeLog').attr('value', data.nomeslog);
                            $('#bairro').attr('value', data.bairro);
                        }
                    ); 
                });        
            });

</script>
	
			<script>
				$(document).ready( function(){
			    //Pega o formulÃƒÂ¡rio com ID ContatoContatoForm e inicia a validaÃƒÂ§ÃƒÂ£o
			    $("#PersonMaster").validate();
				});
			</script>
	
	
	<?php
			echo $this->Form->create('Person', array('class'=>'default2', 'id'=>'PersonMaster'));	
	
			#Dados de pssoa física
			echo '<fieldset>';
			echo '<legend>Identificação do usuário</legend>';
			echo $this->Form->input('Individual.0.nome');
			echo $this->Form->input('Individual.0.identidade');
			echo $this->Form->input('Individual.0.cpf', array('label'=>'CPF', 'id'=>'cpf'));
		
			echo '</fieldset>';
			?>
		
			
				<fieldset>
 <legend>Login e senha</legend>
        <?php
      
        echo $this->Form->input('User.0.username', array('label'=>'Login'));
        echo $this->Form->input('User.0.password', array('label'=>'Senha')); 
		echo $this->Form->input('User.0.confirm_password', array('type' => 'password', 'label'=>'Confirmar senha')); 
		 if(empty($tipocontacttypes)):
			 echo $this->Form->end(__('Cadastrar')); 
		 endif;
		?>
		
		
	</fieldset>		
			<?php if(!empty($tipocontacttypes)): ?>
			<fieldset>
			<table>	
				<legend>Informações de contato</legend>
				<?php 
				 $qtdade_typecontacts= sizeof($tipocontacttypes);
				 	for($i=0; $i < $qtdade_typecontacts; $i++)
				 	{
					?>
					<tr>
					<?php
						$campo = $tipocontacttypes[$i]['Contactstype']['label'];
						$id = $tipocontacttypes[$i]['Contactstype']['tipo']; 	
						echo '<td>'.$this->Form->input('Contact]['.$i.'.'.'contato', array('label' => $campo, 'id'=>$id, 'div'=>'input text required', 'required'=>'required')).'</td>';
						echo $this->Form->hidden('Contact]['.$i.'.'.'contactstype_id', array('value' => $tipocontacttypes[$i]['Contactstype']['id'], 'type'=>'text'));
						echo '<td>'.$this->Form->input('Contact]['.$i.'.'.'pessoa_paracontato', array('label' => 'Pessoa para contato')).'</td>';
					?>
					</tr>
					<?php
					}
				 ?>
			</table>
			
			<?php echo $this->Form->end(__('Cadastrar'));	?>
		</fieldset>
<?php endif; ?>

	<script>
		jQuery(function($)
		{
			$("#dt").mask("99/99/9999");
		    $("#cep").mask("99999-999");
		    $("#cnpj").mask("99.999.999/9999-99");
		    $("#telefone").mask("(99)9999-9999");
		    $("#celular").mask("(99)9999-9999");
		    $("#tel2").mask("(99)9999-9999");
		    $("#cel2").mask("(99)9999-9999");
		    $("#cpf").mask("999.999.999-99");
		});
	</script>
	
	
</div>	