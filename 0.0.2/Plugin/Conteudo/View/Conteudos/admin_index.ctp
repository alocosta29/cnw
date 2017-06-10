<div class="assist">
</div>
<div class="main">
    
    <h2>Administrar conteúdo das sessões</h2>
    
    <table class="scrollQuebra" width="100%"cellpaddin="5px">
    
        <tr>
            <th>Sessão</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>    
    
        <?php foreach($categorias as $cat): ?>
        <tr>
            <td><?php echo $cat['CatConteudo']['categoria']; ?></td>
           <td><?php echo $cat['CatConteudo']['status']; ?></td>
            <td class="actions"><?php echo $this->AclLink->link(__('Editar conteúdo'), array('action' => 'editContent', $cat['CatConteudo']['id'])); ?></td>
        </tr>
        <?php endforeach; ?>
    
    </table>
        
</div>    
