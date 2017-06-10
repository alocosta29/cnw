<div class="assist">
    <?php echo $this->element('Articles.menuCol'); ?>
    
    
    
</div>
<div class="main">
    <h2>Resumo</h2>
    <table class="scrollQuebra" width = '100%' cellpadding = "5px">
    <tr>
        <th width='25%' style="color:#008000; ">Publicados</th>
        <td><?php echo $report['publicados']; ?></td>
        <th width='25%'>Em análise</th>
        <td><?php echo $report['em_analise']; ?></td>
    </tr>  
    
    <tr>
        <th>Em rascunho</th>
        <td><?php echo $report['rascunho']; ?></td>
        <th style="color:#CC0002; ">Artigos que voltaram para revisão</th>
        <td><?php echo $report['reprovados']; ?></td>
    </tr> 
    
    
    
    </table>
    
</div>


