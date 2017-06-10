<?php
App::uses('ManagerAppModel', 'Manager.Model');

class Holiday extends ManagerAppModel 
{
	public $actsAs = array('Locale.Locale');

	public $validate = array
	(
			'data' =>array(
				'uniqueValidation' => array(
						'rule'=>'uniqueValidation',
						'message' => "A data informada já foi cadastrado. Por favor, defina outra data."
				))
				
	);
			
	public function uniqueValidation()
	{
		$form = $this->data;
		if(isset($form['Holiday']['id']))
		{
			$holi_id =  $form['Holiday']['id'];	
			$busca = $this->find('all', array(
			'conditions' => array(
									'data'=>$form['Holiday']['data'],
									'isdeleted'=> 'N',
									'isactive'=> 'Y',
									'NOT'=> array('id'=>$holi_id))));
			
		} else {
			$busca = $this->find('all', array(
			'conditions' => array(	'data'=>$form['Holiday']['data'],
									'isdeleted'=> 'N',
									'isactive'=> 'Y' )));
		}
			
			if(empty($busca))
			{
				$this->data = $form;	
				return true;	
			}else{
				$this->data = $form;
				return false;
			}
	}		
			
			
	
}