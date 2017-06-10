<?php
/*
 * Componente para retorno dos dados do contrato
 */

App::uses('Person', 'Manager.Model');
App::uses('Avatar', 'Avatar.Model');


	class AvatarsDataProcessingComponent extends Component 
	{
		
		public function _retornaPerson($person_id)
		{
            $Person = new Person();
			$person = $Person->find('first', array('conditions'=>array('Person.id'=>$person_id)));
			
			
			if(!empty($person)){
				$retorno['nome'] = $person['Individual'][0]['nome'];
				$retorno['cpf'] = $person['Individual'][0]['cpf'];
			}else{
				
				$retorno = false;
			}
			return $retorno; 
		}
		
		
		/**
		 *  Método Responsável pela permissão da imagem a ser redimensionada
		 */
		 public function _permiteRedimensionamento($id)
		 {
            $Avatar = new Avatar();
		 	$avatar = $Avatar->findById($id);
			
			//Aqui seleciona a pasta
			$file = WWW_ROOT.'img'.DS.'avatars'.DS.$avatar['Person']['id'].DS.$avatar['Avatar']['avatar'];
			$miniFile = WWW_ROOT.'img'.DS.'avatars'.DS.$avatar['Person']['id'].DS.'thumb'.DS.$avatar['Avatar']['avatar'];
			$thumb = WWW_ROOT.'img'.DS.'avatars'.DS.$avatar['Person']['id'].DS.'thumb';
	
			//Verifico se eciste, se não existe crio e dou permissão
			if(!is_dir($thumb)) {mkdir($thumb,'0777');chmod($thumb, 0777);} 
			
			//Verifico se eciste, se existe crio e dou permissão
			if(file_exists($file)) { chmod($file, 0777); } 
			if(file_exists($miniFile)) { chmod($miniFile, 0777); } 
		 }
		 
		
		
		/**
		* Metodo responsavel pela criação e permissão das pastas que armazenam imagens do 
		* person e tambem as miniaturas
		*/
		public function _trataPastaIndividual($person_id)
		{
			//Aqui seleciona a pasta
			$permissao = WWW_ROOT.'img'.DS.'avatars'.DS.$person_id;

			//Verifico se eciste, se não existe crio e dou permissão
			if(!is_dir($permissao)) {mkdir($permissao,'0777');chmod($permissao, 0777);} 

			//salvando a pasta thumb
			$thumb = WWW_ROOT.'img'.DS.'avatars'.DS.$person_id.DS.'thumb';

			//Verifico se eciste, se não existe crio e dou permissão
			if(!is_dir($thumb)) {mkdir($thumb,'0777');chmod($thumb, 0777);} 
			
			//preparo o retorno para salvar o arquivo
			$pasta = WWW_ROOT.'img'.DS.'avatars'.DS.$person_id.DS;

			return $pasta;
		}
		
		
		/**
		 * /Função que verifica a existenia do thumb e apaga.
		 */
		public function _apagarMiniatura($person_id, $nameFile)
		{
			$filename = IMAGES.'avatars'.DS.$person_id.DS.'thumb'.DS.$nameFile;	
			$return = true;
			if (file_exists($filename)) {
			    if(!unlink($filename)){
                    $return = false;
                }
			} 
			return $return;	
		}
		public function _trataDados($data)
		{
			$save['x1'] = number_format($data['x'], 0);	
			$save['y1'] = number_format($data['y'], 0);	
			$save['w'] = number_format($data['w'], 0);	
			$save['h'] = number_format($data['h'], 0);	
			//$save['x2'] = number_format($data['x2'], 0);	
			//$save['y2'] = number_format($data['y2'], 0);		
			return $save;
		}
		public function _deleteAntigosRegistros($avatar_id)
		{
            $Avatar = new Avatar();
			$person = $Avatar->find('first', array('conditions'=>array('Avatar.id' => $avatar_id)));
			$person_id = $person['Avatar']['person_id'];

			if(!$Avatar->updateAll(
			    array('Avatar.isdeleted' => "'Y'"),
			    array('Avatar.person_id' => $person_id,
                'NOT'=>array('Avatar.id'=>$avatar_id)))){
                        return false;
                }else{
                      return true;
                }
		}
		
		
		/**
		 * Função responsavel por validar campo de arquivo
		 */
		 public function _validaArquivo($data)
		 {
			 	if($data['Avatar']['avatar']['error'] > 0)
			 	{
			 		$retorno['resposta'] = false;
					$retorno['msg'] = 'Por favor, escolha um arquivo para upload';
			 	}
			 	else
			 	{
			 		$tamanho = getimagesize($data['Avatar']['avatar']["tmp_name"]);
					if($tamanho[0] > 900 or $tamanho[1] > 900)
					{
						$retorno['resposta'] = false;
						$retorno['msg'] = 'O arquivo esta muito grande. Por favor, escolha um arquivo menor para upload';
					}
					elseif($tamanho[0] < 400 or $tamanho[1] < 400)
					{
						$retorno['resposta'] = false;
						$retorno['msg'] = 'O arquivo esta muito pequeno. A imagem pode ficar distorcida. Por favor, escolha um arquivo maior para upload';	
					}
					else
					{
						$retorno['resposta'] = true;
					}
				}						
				return $retorno;
		 }
		
		
		
		
	}