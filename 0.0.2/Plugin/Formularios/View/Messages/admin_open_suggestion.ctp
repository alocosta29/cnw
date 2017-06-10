<table cellpadding="5px" cellspacing="0" class="scroll" width="100%">
    
        <tr>
            <th>Formulário</th>
            <td style="font-weight: bold; font-size: 16px; ">Caixinha de sugestões</td>
        </tr>
          
        <tr>
            <th>Nome do colaborador</th>
            <td><?php echo $msg['Sugestao']['nome']; ?></td>
        </tr> 
           
        <tr>
            <th>Data de recebimento</th>
            <td><?php echo $this->Time->format('d/m/Y', $msg['Sugestao']['created']); ?></td>
        </tr>
            
        <tr>
            <th>Tipo</th>
            <td><?php echo $this->Formularios->getTypeSuggestion($msg['Sugestao']['tipo']); ?></td>
        </tr>
               
        <tr>
            <th colspan="2">Mensagem</th>
        </tr>  
    
        <tr>
            <td colspan="2"><?php echo $msg['Sugestao']['mensagem']; ?></td>
        </tr> 
     
</table>