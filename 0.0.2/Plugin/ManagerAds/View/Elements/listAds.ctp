    <table cellpadding="2px" cellspacing="0" id="tab" width="100%" class="display" style="font-size: 12px; ">
        <thead>
            <tr>
                    <th>Tipo</th>
                    <th>Início de veiculação</th>
                    <th>Fim de veiculação</th>
                
                    <th>Ações</th>
            </tr>	
        </thead>
        <tbody>
            <?php foreach ($Ads as $variavel): ?>
                <tr>
                        <td><?php echo $variavel['AdType']['tipo']; ?></td>
                        <td><?php echo $this->Time->format('d/m/Y', $variavel['Ad']['data_inicio']); ?></td>
                        <td><?php echo $this->Time->format('d/m/Y', $variavel['Ad']['data_fim']); ?></td>
                       
                        <td class="actions">
                            <?php echo $this->Html->link(__('Detalhes'), array('action' => 'details', $caderno, $variavel['Ad']['id'])); ?>	
                        </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
        <?php echo $this->element('getDataTable', array('id'=>'tab')); ?> 