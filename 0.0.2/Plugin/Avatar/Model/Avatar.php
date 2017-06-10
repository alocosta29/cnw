<?php
App::uses('AvatarAppModel', 'Avatar.Model');

class Avatar extends AvatarAppModel {


	public $name = 'Avatar';
	public $useTable = 'avatars';




	public $validate = array(
		

		'avatar' => array(
					'extensao' => array(
						'rule' => array('extensao'),
						'message' => 'Extensão de arquivo inválida. As extensões permitidas são: jpg ou png',
						'allowEmpty' => TRUE ),
						
					'savename' => array(
						'rule' => array('savename'),
						'message' => 'erro ao salvar o arquivo',
						
						)));
						
						
						
	
	
	public function savename()
	{
		//pr($this->data);
			//exit(0);
		if(isset($this->data['Avatar']['avatar']) and $this->data['Avatar']['avatar']['error'] == 0 )
		{
			//pr($this->data);
			//exit(0);
			
			$arquivo = $this->data['Avatar']['avatar'];
			//$extension = end(explode(".", $arquivo['name']));
			$tmp = explode(".", $arquivo['name']);
			$extension = end($tmp);
			
			$this->data['Avatar']['avatar'] = $this->data['Avatar']['nameFile'].'.'.$extension;	
			
			return true;
		}else
		{
			return true;
		}
	}


		public function extensao()
		{
			if(!empty($this->data['Avatar']['avatar']['name']))
			{
				$extensao = explode('.', $_FILES['data']['name']['Avatar']['avatar']);
				switch ($extensao[1]):
		    	case 'jpg':
		        	return true;
		        break;
				case 'JPG':
		        	return true;
		        break;
		    	case 'png':
			    	return true;
		        break;
				case 'PNG':
			    	return true;
		        break;
		    	default:
					return true;
				endswitch;			
			
			}else{
				return true;
			}
		}





	public $belongsTo = 
	array(
			'Person' => array(
				'className' => 'Manager.Person',
				'foreignKey' => 'person_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			)
		);
}
