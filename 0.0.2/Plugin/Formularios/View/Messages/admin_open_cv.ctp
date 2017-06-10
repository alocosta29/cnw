<table cellpadding="5px" cellspacing="0" class="scroll" width="100%">
    <tr>
        <th>Nome</th>
        <td><?php echo $msg['Rh']['nome']; ?></td>
    </tr>
       
     <tr>
        <th>Área pretendida</th>
        <td><?php echo $msg['Area']['area']; ?></td>
    </tr>
           
       
        <tr>
        <th>Data de recebimento</th>
        <td><?php echo $this->Time->format('d/m/Y', $msg['Rh']['created']); ?></td>
        </tr>
        
        
        <tr>
        <th>Email</th>
        <td><?php echo $msg['Rh']['email']; ?></td>
        </tr>
        <tr>
            
            
        <th>Currículo para download</th>
        <td><?php echo $this->Html->link($msg['Rh']['arquivo_anexo'], array('plugin'=>false, 'controller'=>'download', 'action'=>'getCv', 'admin'=>false,  $msg['Rh']['id'])); ?></td>
        </tr>
        
        
        <tr>
        <th colspan="2">Mensagem</th>
       
        
    </tr>  
    <tr>
         <td colspan="2"><?php echo $msg['Rh']['mensagem']; ?></td>
    </tr> 
     
   </table>