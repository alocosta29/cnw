
<div class="assist">
    <?php echo $this->element('ManagerAds.menuManagerAds'); ?>
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
        <th>Anuncios autorizados por mim</th>
        <td><?php echo $report['total_autorizados_por_mim']; ?></td>
        <th style="color:#CC0002; "></th>
        <td></td>
    </tr> 

    </table>
    
    
</div>