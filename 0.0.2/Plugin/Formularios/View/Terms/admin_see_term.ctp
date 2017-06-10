<div class="main" style="width: 95%; ">
	
    <h2>Termo de adesão de colunistas</h2>	
    
    <table class="scrollQuebra" width="100%" cellpadding="5px">
        
        <tr>
            <th>Data de criação</th>
            <td><?php echo $this->Time->format('d/m/Y', $dataTerm['Term']['created']); ?></td>
        </tr>
       
        <tr>
            <th>Criado por</th>
            <td><?php echo $this->ReturnData->getNameMailUser($dataTerm['Term']['createdby']); ?></td>
        </tr>
        
        <tr>
            <th>STATUS</th>
            <td><?php echo $this->Complement->getStatusActive($dataTerm['Term']['isactive']); ?></td>
        </tr>
        
        <tr>
            <th colspan="2">Texto</th>
        </tr>
        
         <tr>
            <td colspan="2">
            <?php echo $dataTerm['Term']['texto']; ?>            
            </td>
        </tr>

    </table>
</div>
    
    
    
    
    
    
    
    
    
    


</div>
