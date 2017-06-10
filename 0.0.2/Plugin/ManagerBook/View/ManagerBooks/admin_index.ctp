<div class="assist">
    <?php echo $this->element('ManagerBook.menuManagerBook'); ?>
</div>
<div class="main">
    <h2>Resumo</h2>

    <table class="scrollQuebra" width = '100%' cellpadding = "5px">
    <tr>
        <th width='25%' style="color:#008000; ">Publicados</th>
        <td><?php echo $report['total_geral']; ?></td>
        <th width='25%'>Aguardando autorização</th>
        <td><?php echo $report['aguardando_autorizacao']; ?></td>
    </tr>  
    
    <tr>
        <th>Artigos autorizados por mim</th>
        <td><?php echo $report['total_autorizados_por_mim']; ?></td>
        <th style="color:#CC0002; ">Artigos que enviei para revisão</th>
        <td><?php echo $report['reprovados_por_mim']; ?></td>
    </tr> 

    </table>
</div>    
