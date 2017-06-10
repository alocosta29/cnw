<?php 
$param = explode('/',  $_SERVER['REQUEST_URI']);
$pessoa = end($param);
If($pessoa == 'F' or $pessoa == 'add'){
	$tipoPessoa = 'F';
}else{
	$tipoPessoa = 'J';
}
 
echo $this->Html->script(array('Manager.mask2', 'Manager.jquery.validate'));
	?>
		 <style type="text/css">			
			span#loading {display: none;}
		</style>
		<?php $hostCep = $host.'manager/cepEnderecos/ajaxMsg?cep='; ?>
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
				$(document).ready( function() {
				
			    //Pega o formulÃƒÂ¡rio com ID ContatoContatoForm e inicia a validaÃƒÂ§ÃƒÂ£o
			    $("#PersonMaster").validate();
				});
			</script>
	
	
	<?php
			echo $this->Form->create('Person', array('class'=>'default2', 'id'=>'PersonMaster'));	
			echo $this->Form->hidden('Person.tipo_pessoa', array('value'=>$tipoPessoa));	
		if($tipoPessoa == 'F')
		{
			#Dados de pssoa física
			echo '<fieldset>';
			echo '<legend>INFORMAÇÕES DA PESSOA FÍSICA</legend>';
			echo $this->Form->input('Individual.0.nome');
			echo $this->Form->input('Individual.0.identidade');
			echo $this->Form->input('Individual.0.orgao_expedidor', array('label'=>'Orgão Expedidor'));
			echo $this->Form->input('Individual.0.cpf', array('label'=>'CPF', 'id'=>'cpf'));
			$sexo_options = array(
			'M'=>'Masculino',
			'F'=>'Feminino'
			);
			echo $this->Form->input('Individual.0.sexo', array('options'=>$sexo_options));
			echo $this->Form->input('Individual.0.data_nascimento', array( 'label' => 'Data de nascimento',
                            'dateFormat' => 'D/M/Y',
                            'minYear' => date('Y') - 100,
                            'maxYear' => date('Y') - 0 ));
			
			echo $this->Form->input('Individual.0.nacionalidade');
			echo $this->Form->input('Individual.0.naturalidade', array('label'=>'Natural de'));
			echo $this->Form->input('Individual.0.nome_pai', array('label'=>'Nome do pai'));
			echo $this->Form->input('Individual.0.nome_mae', array('label'=>'Nome da mãe'));
		}
		else
		{
			#Dados de pssoa jurídica
			echo '</fieldset><fieldset>';
			echo '<legend>INFORMAÇÕES DA PESSOA JURÍDICA</legend>';
			echo $this->Form->input('Companie.0.cnpj', array('label'=>'CNPJ','id'=>'cnpj'));
			echo $this->Form->input('Companie.0.inscricao_estadual', array('label'=>'Inscrição Estadual'));
			echo $this->Form->input('Companie.0.inscricao_municipal', array('label'=>'Inscrição Municipal'));
			echo $this->Form->input('Companie.0.r_social', array('label'=>'Razão Social'));
			echo $this->Form->input('Companie.0.fantasia', array('label'=>'Nome Fantasia'));
		}
	
			echo '</fieldset><fieldset>';
			echo '<legend>INFORMAÇÕES SOBRE ENDEREÇO</legend>';
				$logr = array(
				''=>'Selecione',
				'Aeroporto'=>'AEROPORTO',
				'Alameda' => 'ALAMEDA',
				'Apartamento' => 'APARTAMENTO',
				'Avenida' => 'AVENIDA',
				'Beco' => 'BECO',
				'Bloco' => 'BLOCO',
				'Caminho' => 'CAMINHO',
				'Escadinha' => 'ESCADINHA',
				'Estação' => 'ESTAÇÃO',
				'Estrada' => 'ESTRADA',
				'Fazenda' => 'FAZENDA',
				'Fortaleza' => 'FORTALEZA',
				'Galeria' => 'GALERIA',
				'Ladeira' => 'LADEIRA',
				'Lagoa' => 'LAGOA',
				'Praça' => 'PRAÇA',
				'Parque' => 'PARQUE',
				'Praia' => 'PRAIA',
				'Quadra' => 'QUADRA',
				'Kilômetro' => 'QUILÔMETRO',
				'Rodovia' => 'RODOVIA',
				'Rua' => 'RUA',
				'Sítio'=>'SITIO',
				'Super Quadra' => 'SUPER QUADRA',
				'Travessia' => 'TRAVESSA',
				'Viaduto' => 'VIADUTO',
				'Vila' => 'VILA',
				);
				
				$estado = array(
				'' => 'Selecione',
				'AC'=>'Acre', 
				'Al'=>'Alagoas', 
				'AP'=>'Amapá', 
				'AM'=>'Amazonas', 
				'BA'=>'Bahia', 
				'CE'=>'Ceará', 
				'DF'=>'Distrito Federal', 
				'ES'=>'Espírito Santo', 
				'GO'=>'Goiás', 
				'MA'=>'Maranhão', 
				'MT'=>'Mato Grosso', 
				'MS'=>'Mato Grosso do Sul', 
				'MG'=>'Minas Gerais', 
				'PA'=>'Pará', 
				'PB'=>'Paraíba', 
				'PR'=>'Paraná', 
				'PE'=>'Pernambuco', 
				'PI'=>'Piauí', 
				'RJ'=>'Rio de Janeiro', 
				'RN'=>'Rio Grande do Norte', 
				'RS'=>'Rio Grande do Sul',
				'RO'=>'Rondônia', 
				'RR'=>'Roraima', 
				'SC'=>'Santa Catarina', 
				'SP'=>'São Paulo', 
				'SE'=>'Sergipe', 
				'TO'=>'Tocantins', 
				 );
					
				echo $this->Form->input('Addresse.0.cep', array('id'=>'cep'));
				echo $this->Form->input('Addresse.0.tipologradouro', array('options'=>$logr, 'id'=>'logradouro', 'label'=>'Tipo de logradouro'));
				echo $this->Form->input('Addresse.0.logradouro', array('id'=>'nomeLog'));
				echo $this->Form->input('Addresse.0.numero');
				echo $this->Form->input('Addresse.0.complemento');
				echo $this->Form->input('Addresse.0.bairro', array('id'=>'bairro'));
				echo $this->Form->input('Addresse.0.cidade', array('id'=>'cidade'));		
				echo $this->Form->input('Addresse.0.estado', array('options'=>$estado, 'id'=>'uf'));
				echo $this->Form->input('Addresse.0.pais', array('default'=>'Brasil'));

				echo '</fieldset>';
		?>

		<fieldset>
			<table>	
				<legend>INFORMAÇÕES DE CONTATO</legend>
				<?php 
				 $qtdade_typecontacts= sizeof($tipocontacttypes);
				 	for($i=0; $i < $qtdade_typecontacts; $i++)
				 	{
					?>
					<tr>
					<?php
						$campo = $tipocontacttypes[$i]['Contactstype']['label'];
						$id = $tipocontacttypes[$i]['Contactstype']['tipo']; 	
						echo '<td>'.$this->Form->input('Contact]['.$i.'.'.'contato', array('label' => $campo, 'id'=>$id)).'</td>';
						echo $this->Form->hidden('Contact]['.$i.'.'.'contactstype_id', array('value' => $tipocontacttypes[$i]['Contactstype']['id'], 'type'=>'text'));
						echo '<td>'.$this->Form->input('Contact]['.$i.'.'.'pessoa_paracontato', array('label' => 'Pessoa para contato')).'</td>';
					?>
					</tr>
					<?php
					}
				 ?>
			</table>
		</fieldset>


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