
<div class="main">
    <h2>Configurações de permissões de usuário</h2>
    <table class="scrollQuebra" width="100%" cellpadding="5px" >
        <tr>
            <th>NOME DO USUÁRIO</th>
            <td><?php echo $permissions['nome']; ?></td>
        </tr>
         <tr>
            <th>LOGIN DO USUÁRIO</th>
            <td><?php echo $permissions['username']; ?></td>
        </tr>
         <tr>
            <th>STATUS DO USUÁRIO</th>
            <td><?php echo $this->Complement->getStatusActive($permissions['isactive']); ?></td>
        </tr> 
        <tr>
            <th colspan="2">TABELA DE PERMISSÕES</th>
            <td></td>
        </tr>
        <?php if(!empty($permissions['packages'])): ?>
         <tr>
             <td colspan="2">
                 <table class="scrollQuebra" width="100%" cellpadding="5px" >
                     <tr>
                         <th>Pacote</th>
                         <th>Descrição</th>
                         <th>Possui permissão?</th>
                         <th>Detalhes da pemissão</th>
                         <th>Ações</th>
                     </tr>
                     <?php foreach($permissions['packages'] as $packages): ?>
                        <tr>
                            <td><?php echo $packages['nome']; ?></td>
                            <td><?php echo $packages['descricao']; ?></td>
                            <td><?php echo $this->Complement->getStatusYesNo($packages['permission']); ?></td>
                            <td><?php echo $packages['detalhes']; ?></td>
                            <td class="actions"><?php echo $this->AclLink->link('Configurar permissão', $packages['link']); ?></td>
                        </tr>
                     
                     <?php endforeach; ?>
                 </table>
                 
             </td>
        </tr>
        <?php endif; ?>
    </table>
    
</div>