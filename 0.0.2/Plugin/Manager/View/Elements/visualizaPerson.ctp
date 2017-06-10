<div class='telatoda'>
	
<table class="scrollQuebra" width="100%">
<tr>
	<th>
			<?php
                   if($person['Person']['tipo_pessoa'] == 'F'){
                       echo '<strong> <font size = 5px color = #000><center>'.$person['pessoa_fisica']['nome'].'</center></strong></font>';
                   }elseif($person['Person']['tipo_pessoa'] == 'J'){
                       echo '<strong> <font size = 5px color = #000><center>'.$person['pessoa_juridica']['fantasia'].'</center></strong></font>';
                   }     
					
			 ?>
	 </th>
	 <td class="actions">
		<?php echo $this->Html->link('Editar dados', array('controller'=>'persons', 'action'=>'edit', $person['Person']['id'])); ?>			

	</td>
</tr>	
<tr>
	<td>
				<?php 
				if($person['Person']['tipo_pessoa'] == 'F')
				{ ?>
					<table width="500px">
						<tr>
							<th colspan="2"><strong>DADOS DE PESSOA FÍSICA</strong></th>
						</tr>
						<tr>
							<th>Identidade</th>
							<td><?php echo $person['pessoa_fisica']['identidade']; ?></td>
						</tr>
						<tr>
							<th>Orgão expedidor</th>
							<td><?php echo $person['pessoa_fisica']['orgao_expedidor']; ?></td>
						</tr>
						<tr>
							<th>Cpf</th>
							<td><?php echo $this->FormatManager->_mask($person['pessoa_fisica']['cpf'],'###.###.###-##');
							?></td>
						</tr>
						<tr>
							<th>Data de nascimento</th>
							<td><?php 
							if(!empty($person['pessoa_fisica']['data_nascimento'])):
							echo $this->Time->format('d/m/Y', $person['pessoa_fisica']['data_nascimento']);
                            endif;
							?></td>
						</tr>
						<tr>
							<th>Sexo</th>
							<td><?php echo $person['pessoa_fisica']['sexo']; ?></td>
						</tr>
						<tr>
							<th>Nacionalidade</th>
							<td><?php echo $person['pessoa_fisica']['nacionalidade']; ?></td>
						</tr>
						<tr>
							<th>Naturalidade</th>
							<td><?php echo $person['pessoa_fisica']['naturalidade']; ?></td>
						</tr>
						<tr>
							<th>Nome da mãe</th>
							<td><?php echo $person['pessoa_fisica']['nome_mae']; ?></td>
						</tr>
						<tr>
							<th>Nome do pai</th>
							<td><?php echo $person['pessoa_fisica']['nome_pai']; ?></td>
						</tr>
                        <tr><td colspan="2"><br></td></tr>
					</table>
				<?php	
				}else
				{ ?>
					<table width="500px">
					<tr>
					<th colspan="2">
					DADOS DE PESSOA JURÍDICA	
					</th>
					</tr>
					<tr>
						<th>Nome fantasia</th>
						<td><?php echo $person['pessoa_juridica']['fantasia']; ?></td>
					</tr>
					<tr>
						<th>CNPJ</th>
						<td><?php echo $person['pessoa_juridica']['cnpj']; ?></td>
					</tr>
					<tr>
						<th>Inscrição Estadual</th>
						<td><?php echo $person['pessoa_juridica']['inscricao_estadual']; ?></td>
					</tr>
					<tr>
						<th>Inscrição Municipal</th>
						<td><?php echo $person['pessoa_juridica']['inscricao_municipal']; ?></td>
					</tr>
					<tr><td colspan="2"><br></td></tr>
					</table>
				<?php }	 ?>
				
				<table width="500px">
				<tr>
					<th colspan="2"><strong>
						INFORMAÇÕES DE ENDEREÇO
					</strong></th>
                    </tr>
                    <?php if(!empty($person['endereco'])){ ?>
                    <tr>
                        <th>Cep</th>
                        <td><?php echo $person['endereco']['cep']; ?></td>				
                    </tr>

                    <tr>
                        <th>Logradouro</th>
                        <td><?php echo $person['endereco']['tipologradouro'].' '.$person['endereco']['logradouro']; ?></td>				
                    </tr>

                    <tr>
                        <th>Número</th>
                        <td><?php echo $person['endereco']['numero']; ?></td>				
                    </tr>

                    <tr>
                        <th>Complemento</th>
                        <td><?php echo $person['endereco']['complemento']; ?></td>				
                    </tr>

                    <tr>
                        <th>Bairro</th>
                        <td><?php echo $person['endereco']['bairro']; ?></td>				
                    </tr>

                    <tr>
                        <th>Cidade</th>
                        <td><?php echo $person['endereco']['cidade']; ?></td>				
                    </tr>

                    <tr>
                        <th>Estado</th>
                        <td><?php echo $person['endereco']['estado']; ?></td>				
                    </tr>

                    <tr>
                        <th>País</th>
                        <td><?php echo $person['endereco']['pais']; ?></td>				
                    </tr>

				<?php }else{ ?>	
						<tr>
							<th colspan="2" style="color: red">Não existe informações de endereço cadastradas para esse usuário</th>						
						</tr>
					
				<?php } ?>	
                </table>	

	</td>
	<td  align="center" style="vertical-align:top;">
					<table width="500px">
					<tr>
                        <th colspan="2">
                        <strong>DADOS DE LOGIN/SENHA</strong>	
                        </th>
                    </tr>
                    <?php if(!empty($person['user']))
                    { ?>
					<tr>	
                        <th>Usuário</th>
                        <td><?php echo $person['user']['username']; ?></td>
                    </tr>
                    
                    <tr>	
                        <th>Grupo de acesso</th>
                        <td><?php echo $person['user']['grupo']; ?></td>
                    </tr>
                    
                    <tr>	
                        <th>Status</th>
                        <td><?php echo $this->Complement->getStatus($person['user']['status']); ?></td>
                    </tr> 
                    
                    <tr>	
                        <th>Permissões especiais</th>
                        <td><?php 
                             if(!empty($person['permissoes']))
                             {
                                 $i=0; $totalSize = sizeof($person['permissoes']);
                  
                                 while($i<$totalSize)
                                 {
                                     echo '<strong>- '.$person['permissoes'][$i]['nome'].'</strong> <span style="font-size: 12px; ">('.$person['permissoes'][$i]['descricao'].')</span>'.'</br> ';
                                     $i++;
                                 }
                  
                             }else{
                                 echo 'O usuário não possui permissões especiais';
                             }   
                            ?>
                        </td>
                    </tr> 
                                        
                    <tr>	
                        <th>Ações</th>
                        <td class="actions">
                        <?php
                                if($person['user']['status'] > 0)
                                {
                                  echo $this->AclLink->postLink(__('Desativar usuário'), array('plugin'=>'manager', 'controller'=>'users', 'action' => 'disableuser', 
                                  $person['user']['id']), null, __('Você tem certeza que deseja desativar o usuário %s?', $person['user']['username'])); 
                                }else{
                                  echo $this->AclLink->postLink(__('Reativar usuário'), array('plugin'=>'manager', 'controller'=>'users', 'action' => 'reactivate', 
                                  $person['user']['id']), null, __('Você tem certeza que deseja reativar o usuário %s?', $person['user']['username'])); 
                                }
                                echo $this->Html->link('Editar usuário', array('controller'=>'users', 'action'=>'edit', 'admin'=> true, 'plugin'=>'manager', $person['user']['id']));
                                echo $this->AclLink->link('Designar permissão', array('plugin'=>'access_users', 'controller'=>'AccessUsers', 'action'=>'designatePermission', $person['user']['id']));
                        ?>
                        </td>
                    </tr> 

					<?php }else{ ?>		
                    <tr>
                        <td colspan="2">
                        <strong>O usuário não possui login/senha cadastrado</strong>	
                        </td>
                    </tr>
                   <tr>
					<td colspan="2" class="actions"><?php echo $this->Html->link('Cadastrar login/senha', array('controller'=>'users', 'action'=>'add', $person['Person']['id'])); ?></td>
					</tr>
					<?php } ?>
					<tr>
                        <td colspan="2"><br></td>
                    </tr>			
	
					<tr><th colspan="2"><strong>INFORMAÇÕES DE CONTATO</strong></th></tr>
					<?php 
					if(!empty($person['contato']))
                    {
                        foreach($person['contato'] as $contato): ?>
                        <tr>
                            <td><?php echo $contato['label']; ?></td>
                            <td><?php echo $contato['contato']; ?></td>
                            <td><?php echo $contato['pessoa_paracontato']; ?></td>
                        </tr>       
                        <?php endforeach; 
                    }else{
                        echo '<tr><td colspan="3">Não cadastrado</td></tr>';
                    }
					?>	
		</table>
	</td>	
</tr>
</table>
</div>
