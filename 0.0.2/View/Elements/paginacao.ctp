<?php 
$numberPage = $this->Paginator->counter('{:pages}');
if($numberPage > 1): ?>
<p>
	<?php
    	echo $this->Paginator->counter(array(
    	'format' => __('Página {:page} de {:pages}, mostrando {:current} registros de um total de {:count}, iniciando em {:start}, terminando em {:end}')
    	));
	?>	
</p>
<div id="paging">
	<?php
		echo $this->Paginator->prev(__('ANTERIORES <<'), array(), null, array('class' => 'prevdisabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('>> PRÓXIMOS'), array(), null, array('class' => 'nextdisabled'));
	?>
</div>
<?php endif; ?>