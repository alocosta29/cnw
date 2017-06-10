<?php if($dataArticle['status'] == 'N'): ?>
<br>
<table class="scrollQuebra" width="100%" cellpadding = "5px">
   <tr>
        <th>Avaliado por </th><td><?php echo $this->ReturnData->getNameMailUser($dataArticle['reprovedby']); ?></td>
   </tr>
   <tr>
        <th>Data da avaliação </th><td><?php echo $this->Time->format('d/m/Y H:i', $dataArticle['reprobation_date']); ?></td>
   </tr>
   <tr>
       <th colspan="2">Observações</th>
   </tr>
   <tr>
       <td colspan="2"><?php echo $dataArticle['comments']; ?></td>
   </tr>
</table>
<br>
<?php endif; ?>