<div class="assist">
 <?php echo '<br>'.$this->element('Articles.linksEditPerfil'); ?>  
</div>    

<div class="main">
    <h2>Gerenciamento do perfil de colunista</h2>

    <table class="scrollQuebra" width="100%" cellpadding = "5px">
        <tr>
            <td rowspan="5" width="17%"> 
            <?php 
            echo $this->Avatar->getThumbAvatar(
                    array(
                            'person_id'=>$profile['person_id'], 
                            'genero'=>$profile['sexo'], 
                            'image'=>$profile['avatar'],
                            'idAvatar' => $profile['avatar_id'],
                            'caderno' => $caderno
                        ));
            ?>
            
        </td>
            <th>Apelido</th>
            <td><?php echo $profile['apelido']; ?></td>
        </tr>    
    
        <tr>
           <th>Nome</th>
           <td><?php echo $profile['nome']; ?></td> 
        </tr>
        
        <tr>
           <th>Apelido</th>
           <td><?php echo $profile['apelido']; ?></td> 
        </tr>
        
        <tr>
           <th>Alias</th>
           <td><?php echo $profile['alias']; ?></td> 
        </tr>
        
        <tr>
           <th>CPF</th>
           <td><?php echo $this->Complement->mask($profile['cpf'], '###.###.###-##'); ?></td> 
        </tr>

        <tr>
           <th>Sexo</th>
           <td colspan="2"><?php echo $this->Complement->getSex($profile['sexo']); ?></td> 
        </tr>
 <tr>
            <td colspan="3"><br></td>
        </tr>
        <tr>
            <th colspan="3">RESUMO</th>
        </tr>
         <tr>
            <td colspan="3"><?php echo $profile['resumo']; ?></td>
        </tr>
        <tr>
            <td colspan="3"><br></td>
        </tr>
          <tr>
            <th colspan="3">BIOGRAFIA</th>
        </tr>
         <tr>
            <td colspan="3"><?php echo $profile['bio']; ?></td>
        </tr>
        
        
        
    </table>
</div>
