<?php
App::uses('ManagerAppModel', 'Manager.Model');

class Role extends ManagerAppModel {

    public $name = 'Role';
    public $displayField = 'alias';
    public $actsAs = array(
        'Acl' => array(
            'type' => 'requester',
        ),
    );

    public function parentNode() {
        return null;
    }
    
    public $validate = array(   
    	'alias' => array(	
			'notempty' => array(
				'rule' => array('notempty'),
    			'message' => 'Nome do grupo nao pode ficar vazio!'
    		),
 			'isUniqueOptimize' => array(
        		'rule'    => 'isUniqueOptimize',
        		'message' => 'O nome do grupo ja existe. Por favor, escolha outro!',
    		)
    	)
	);
    
  public function isUniqueOptimize()
  {	
		$form = $this->data;	
		$alias= $form['Role']['alias']; 		
		$options = array(
		        "conditions" => array(
		        'NOT'=>array('isdeleted'=>'Y'),
				'alias' => $alias
			));
		
		if(isset($form['Role']['id'])){
			$options['conditions']['NOT']['id'] = $form['Role']['id'];
		}
		$result = $this->find("count", $options);	

	 	if($result > 0){
				$this->data = $form;
				return false;			
		}else{
				$this->data = $form;
				return true;
		}
  }
  
  
  
  
    public $hasAndBelongsToMany = array(
    		'User' => array(
    			'className' => 'Manager.User',
    			'joinTable' => 'roles_users',
    			'foreignKey' => 'role_id',
    			'associationForeignKey' => 'user_id',
				//'unique' => true,
    			'conditions' => '',
    			'fields' => '',
    			'order' => '',
    			'limit' => '',
    			'offset' => '',
    			'finderQuery' => '',
    			'deleteQuery' => '',
    			'insertQuery' => ''
  		  	),
    		/*'RtSmart' => array(
    			'className' => 'Report.RtSmart',
    			'joinTable' => 'rt_smart_roles',
    			'foreignKey' => 'role_id',
    			'associationForeignKey' => 'rt_smart_id',
    			'unique' => 'keepExisting',
    			'conditions' => '',
    			'fields' => '',
    			'order' => '',
    			'limit' => '',
    			'offset' => '',
    			'finderQuery' => '',
    			'deleteQuery' => '',
    			'insertQuery' => ''
    		)*/
    );
}
?>