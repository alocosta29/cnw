<div class="assist">
	<?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>
<div class="main">
<h2><?php echo $this->ReturnData->getBook($caderno).': ';   ?>Ficha do colunista </h2>	
    <table class="scrollQuebra" width="100%" cellpadding="5px">
        <tr>
            <th>Nome completo</th>
            <td colspan ='3' style="font-size: 19px; "><?php echo $profile['nome']; ?></td>
        </tr>
        
        <tr>
        <th>CPF</th>
        <td><?php echo $this->Complement->mask($profile['cpf'],'###.###.###-##'); ?></td>
        <th>Sexo</th> 
        <td><?php 
        if(!empty($profile['data_nascimento'])){
        echo $this->FormatManager->getSex($profile['sexo']); 
        }
        ?></td>   
        </tr>
                
        <tr>
        <th>Data de nascimento</th>
        <td><?php 
                if(!empty($profile['data_nascimento'])){
                    echo $this->Time->format('d/m/Y', $profile['data_nascimento']); 
                }
                ?>
        </td>
        <th>Apelido</th> 
        <td><?php echo $profile['apelido']; ?></td>   
        </tr>
        <tr>
            <td colspan="4"><br></td>
        </tr> 
        <tr>
            <th colspan="4" style="text-align: center; ">INFORMAÇÕES DE USUÁRIO</th>
        </tr>
        <?php if($profile['is_user']): ?>
        <tr>
            <th>Username</th>
            <td><?php echo $profile['username']; ?></td>
               <th>Status de usuário</th>
            <td><?php echo $profile['statusDescription']; ?></td>
        </tr>
        <?php if($profile['recent_register'] == 'Y'): ?>
        <tr>
            <th>Observações</th>
            <td> Usuário recém cadastrado em <?php echo $this->Time->format('d/m/Y H:i', $profile['created']); ?></td>
            <th>Senha temporária</th>
            <td><?php echo $profile['pass_register']; ?></td>
       </tr>
        <?php endif; ?>
         <tr>
            <td colspan="4"><br></td>
        </tr> 
        
        <tr>
           <th colspan="4" style="text-align: center; ">PERMISSÕES DE USUÁRIO</th>
        </tr>
        
        <tr>
            <th>Permissão de colunista</th>
            <td class="actions">
                <?php if(!$profile['permission_col']['permission'])
                      { 
                        echo 'NÃO';	
                      }else{
                          echo 'SIM';
                      } ?>
            </td>
            <th>Permissão de moderador</th>
            <td class="actions">
                    <?php if(!$profile['permission_adm']['permission'])
                      { 
                        echo 'NÃO';	
                      }else{
                          echo 'SIM';
                      } ?> 
                
            </td>
       </tr>
       <tr>
           <td></td>
           <td class="actions">
                      <?php if(!$profile['permission_col']['permission'])
                      { 
                        echo $this->Form->postLink(__('Ativar permissão de colunista'), array('action' => 'allowBook',  $book, 'col', $profile['user_id']), null, __('Tem certeza que deseja ativar a permissão de col ?', null));	
                      }else{
                         echo $this->Form->postLink(__('Retirar permissão de colunista'), array('action' => 'denyBook',  $book, 'col', $profile['user_id']), null, __('Tem certeza que deseja retirar a permissão de col ?', null));
                      } ?>
               
           </td>
           
           <td></td>
           <td class="actions">
               <?php if(!$profile['permission_adm']['permission'])
                      { 
                        echo $this->Form->postLink(__('Ativar permissão de moderador'), array('action' => 'allowBook', $book, 'adm', $profile['user_id']), null, __('Tem certeza que deseja ativar a permissão de adm ?', null));	
                      }else{
                        echo $this->Form->postLink(__('Retirar permissão de moderador'), array('action' => 'denyBook', $book, 'adm', $profile['user_id']), null, __('Tem certeza que deseja retirar a permissão de adm ?', null));	
                      } ?> 
               
           </td>
       </tr>

        
        
        
        <?php endif; ?>
     
        
     </table>   
</div> 