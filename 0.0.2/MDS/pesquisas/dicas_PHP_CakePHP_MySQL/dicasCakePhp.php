<?php
####################################################################################################################
######## Para permitir que o acesso ao método seja apenas via post. ideal para o método que apaga registros ########
$this->request->onlyAllow('post', 'delete');

####################################################################################################################
######## BETWEEN query em CAKEPHP ########
/*BETWEEN AND SQL syntax in CakePHP
This is how you’d write a BETWEEN… AND… SQL query in a cake-like way.
The example should be pretty much self explanatory:*/
$this->Post->find('all', array('conditions'=>array('Post.id BETWEEN ? AND ?' => array(1, 10))));
#Note, that CakePHP will quote the numeric values depending on the field type in your DB.

####################################################################################################################
######## TRANSACTIONS em CAKEPHP ########
$save = $this->request->data;
$datasource = $this->Model->getDataSource();
try{
	$datasource->begin();

	if(!$this->Model->save($save))
		throw new Exception();				
							
	$datasource->commit();
}catch(Exception $e){
	$datasource->rollback();
}
		
####################################################################################################################
######## updateAll em CAKEPHP ########		
$this->Baker->updateAll(
    array('Baker.approved' => true),
    array('Baker.created <=' => $thisYear)
);	

$this->Ticket->updateAll(
    array('Ticket.status' => "'closed'"),
    array('Ticket.customer_id' => 453)
);

$db = $this->getDataSource();
$value = $db->value($value, 'string');
$this->updateAll(
    array('Baker.status' => $value),
    array('Baker.status' => 'old')
);

######################################################################################################################
#find com pesquisa de data quebrada
$mes = date('m');
$ano = date('Y');
$options = array(
					'conditions' => array('Employee.isactive' => 'Y', 'MONTH(Employee.data_admissao) <=' => $mes, 'YEAR(Employee.data_admissao) <' => $ano),
					'order' => array('Employee.data_admissao' => 'ASC'),
					'limit' => 20
				 );
$this->paginate = $options;
$periodoAquisitivo = $this->paginate('Employee');
		
		
		
		
		