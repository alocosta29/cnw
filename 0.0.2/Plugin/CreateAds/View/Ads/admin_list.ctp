<div class="assist" style="width: 15%;">
    <?php echo $this->element('CreateAds.menuAds'); ?>
</div>
<div class="main" style="width: 80%;">

    <h2>Anúncios criados</h2>	

    <table cellpadding="2px" cellspacing="0" id="tab" width="100%" class="display" style="font-size: 12px; ">

        <thead>
            <tr>
                    <th>Tipo</th>
                    <th>Início de veiculação</th>
                    <th>Fim de veiculação</th>
                    <th>Status</th>
                    <th>Ações</th>
            </tr>	
        </thead>

        <tbody>
            <?php foreach ($Ads as $variavel): ?>
                <tr>
                        <td><?php echo h($variavel['AdType']['tipo']); ?></td>
                        <td><?php echo $this->Time->format('d/m/Y', $variavel['Ad']['data_inicio']); ?></td>
                        <td><?php echo $this->Time->format('d/m/Y', $variavel['Ad']['data_fim']); ?></td>
                        <td><?php echo $this->Complement->getStatusAd($variavel['Ad']['status']); ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('Detalhes'), array('action' => 'view', $caderno, $variavel['Ad']['id'])); ?>	
                        </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        </table>
        <?php echo $this->element('getDataTable', array('id'=>'tab')); ?>   

</div>
