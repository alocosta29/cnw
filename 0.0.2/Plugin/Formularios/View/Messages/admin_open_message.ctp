<div class="main">
    <h2>Visualizar mensagem</h2>
<table cellpadding="5px" cellspacing="0" class="scroll" width="100%">
    
        <tr>
            <th>Formulário</th>
            <td style="font-weight: bold; font-size: 16px; "><?php echo $msg['Formulario']['nome']; ?></td>
        </tr>
          
        <tr>
            <th>Nome</th>
            <td><?php echo $msg['Contato']['nome']; ?></td>
        </tr> 
           
        <tr>
            <th>Data de recebimento</th>
            <td><?php echo $this->Time->format('d/m/Y', $msg['Contato']['created']); ?></td>
        </tr>
            
        <tr>
            <th>Email</th>
            <td><?php echo $msg['Contato']['email']; ?></td>
        </tr>
               
        <tr>
            <th colspan="2">Mensagem</th>
        </tr>  
    
        <tr>
            <td colspan="2"><?php echo $msg['Contato']['mensagem']; ?></td>
        </tr> 
     
</table>
    <br>
    <?php
    $voltar = $this->Html->image('voltar.png', array('title'=>'Voltar')); 
    echo $this->Html->link($voltar, array('action'=>'listContacts'), array('escape'=>false));
    ?>
    
    </div>