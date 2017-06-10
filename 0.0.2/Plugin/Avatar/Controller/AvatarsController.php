<?php
App::import('Vendor','Avatar.WideImage/WideImage');
//App::import('Avatar.Vendor', 'WideImage', array('file' => 'WideImage/WideImage.php'));
//App::uses('WideImage/WideImage', 'Avatar.Vendor');
App::uses('AvatarAppController', 'Avatar.Controller');

class AvatarsController extends AvatarAppController 
{
    public $components = array('Avatar.AvatarsDataProcessing');
        
    public function beforeFilter()
	{
        parent::beforeFilter();
        if($this->Session->read('Auth.User')){
            $this->Auth->allow(array('admin_add', 'admin_redimensiona', 'admin_delete'));
        }
	}
    
	public function admin_add($caderno = null) 
	{
        $id = $this->Session->read('Auth.User.person_id');
		$valida = $this->AvatarsDataProcessing->_retornaPerson($id);
		if(!empty($valida['nome']))
		{
			if($this->request->is('post')) 
			{
				$data = $this->request->data;
				$data['Avatar']['person_id'] = $id;
				//Aqui crio o nome para o arquivo
				$data['Avatar']['nameFile'] = date('dmYHis');
				$validaArquivo = $this->AvatarsDataProcessing->_validaArquivo($data);                
				if($validaArquivo['resposta'])
                {
                    $arquivo = $data['Avatar']['avatar'];
                    $datasource = $this->Avatar->getDataSource();
                    try{
                        $datasource->begin();

                        if(!$this->Avatar->save($data)){
                               throw new Exception();
                        }else{
                             $avatar_id = $this->Avatar->id;                 
                            $pasta = $this->AvatarsDataProcessing->_trataPastaIndividual($id);
                            if(!$this->_uploadFile($arquivo, $pasta, $data['Avatar']['nameFile'])){
                               throw new Exception();
                            }                            
                            
                            if(!$this->AvatarsDataProcessing->_deleteAntigosRegistros($avatar_id)){
                               throw new Exception();
                            }
                            
                            if(!$this->_saveThumb($avatar_id)){
                               throw new Exception();
                            }	
                        }				
                        $datasource->commit();
                        $this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
                        $this->redirect(array('action' => 'redimensiona', $caderno, $avatar_id));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array('class' => 'error'));
                    }
                }else{
                    $this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array('class' => 'error'));
                }
			}
			$this->set('person', $this->AvatarsDataProcessing->_retornaPerson($id));
			$this->set('id', $id);
            $this->set('caderno', $caderno);
		}else{
			$this->Session->setFlash(__('Registro não localizado!!'), 'default', array('class' => 'error'));
		}
       
	}

	private function _saveThumb($id)
    {
        try{
                $options = array('conditions' => array('Avatar.' . $this->Avatar->primaryKey =>$id));
                $registro = $this->Avatar->find('first', $options);		
                $person_id = $registro['Avatar']['person_id'];

                $dir = IMAGES.'avatars'.DS.$person_id.DS;	
                $file = $registro['Avatar']['avatar'];
                $filename = $dir.$registro['Avatar']['avatar'];
                $thumb = IMAGES.'avatars'.DS.$person_id.DS.'thumb'.DS;

                if(!is_dir($thumb))
                {
                    mkdir("$thumb", 0777);
                    chmod($thumb, 0777);
                }else{
                    chmod($thumb, 0777);
                }

                $output_dir = $thumb.$registro['Avatar']['avatar'];
                $img = WideImage::load($filename);
                $img = $img->crop('50% - 195', '50% - 195', 390, 390);
                //$img = $img->asGrayscale();
                $img->saveToFile($output_dir);
                $return = true;
            }catch (Exception $e){
                $return = false;
            }
        return $return;
    }


	public function admin_redimensiona($caderno = null, $id = null)
	{
 
		$this->Avatar->id = $id;
		$busca = $this->Avatar->find('first', 
                                            array('conditions'=>array(  'Avatar.id'=>$id,
                                                                        'Avatar.isdeleted' => 'N'
                                                                      )));
		if(empty($busca) and !isset($busca['Avatar'])) 
		{
			throw new NotFoundException(__($this->Mensagens->registroInvalido));
		}	
		//aqui recupero dados da imagem
		$options = array('conditions' => array('Avatar.' . $this->Avatar->primaryKey =>$id));
		$registro = $this->Avatar->find('first', $options);		
		$person_id = $registro['Avatar']['person_id'];	
		$output_dir = IMAGES.'avatars'.DS.$person_id.DS.'thumb'.DS.$registro['Avatar']['avatar'];
		//Aqui pego as variaveis e mando para a view
		$image['normal'] = HOST_IMAGE.'avatars'.DS.$person_id.DS;
		$image['thumb'] = HOST_IMAGE.'avatars'.DS.$person_id.DS.'thumb'.DS;
		$this->AvatarsDataProcessing->_permiteRedimensionamento($id);
			if($this->request->is('post') || $this->request->is('put'))
			{
				$corte = $this->request->data['Avatar'];	
               try{
                        if(!empty($corte['x']) and !empty($corte['y']))
                        {
                                $dir = IMAGES.'avatars'.DS.$person_id.DS;
                                $filename = $dir.$registro['Avatar']['avatar'];
                               // chmod ($output_dir, 0777); 
                               // chmod ($filename, 0777); 
                                //chmod ($dir, 0777); 
                                if($this->AvatarsDataProcessing-> _apagarMiniatura($person_id, $registro['Avatar']['avatar'])){
                                    $corteFormatado = $this->AvatarsDataProcessing->_trataDados($corte);
                                    // Corta a imagem (Argumentos: X1, Y1, X2, Y2)
                                   // $WideImage  = new WideImage();
                                    $img = WideImage::load($filename);
                                   //pr($filename); exit(0);
                                    $img = WideImage::load($filename); 
                                    $img = $img->crop($corteFormatado['x1'], $corteFormatado['y1'], $corteFormatado['w'], $corteFormatado['h']);
                                    //$img = $img->crop('50% - 61', '50% - 82', 123, 164);
                                    $img = $img->resize(390, 390);
                                    $img = $img->asGrayscale();
                                    if($img->saveToFile($output_dir)){
                                      $this->Session->setFlash(__('Imagem redimensionada com sucesso'), 'default', array('class' => 'success'));   
                                       header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                                       header("Cache-Control: post-check=0, pre-check=0", false);
                                       header("Pragma: no-cache");
                                    }
                                }else{
                                    $this->Session->setFlash(__('A imagem antiga não pode ser deletada! Verifique com o setor de desenvolvimento as permissões de pasta e tente novamente!!'), 'default', array('class' => 'error'));
                                }
                          
                        }else{
                                $this->Session->setFlash(__('Nenhuma parte da imagem foi selecionada. Por favor, tente novamente!!'), 'default', array('class' => 'error'));
                        }
                         
                        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                        header("Cache-Control: post-check=0, pre-check=0", false);
                        header("Pragma: no-cache");
                    }catch(Exception $e){
                       $this->Session->setFlash(__('Não foi possível redimensionar a imagem. Verifique com o setor de desenvolvimento as permissões de pasta e tente novamente!!'), 'default', array('class' => 'error')); 
                    }
			}
       
		$this->set('person', $this->AvatarsDataProcessing->_retornaPerson($person_id));
		$this->set('registro', $registro);
		$this->set('image', $image);
        $this->set('caderno', $caderno);

	}

	public function admin_delete($caderno = null, $id = null) 
	{
                $this->Avatar->id = $id;
                if(!$this->Avatar->exists()) 
                {
                    throw new NotFoundException(__($this->Mensagens->registroInvalido));
                }
                
				$AvatarParaDeletar = $this->Avatar->read(null, $id);
				$AvatarParaDeletar['Avatar']['isdeleted'] = 'Y';
				$AvatarParaDeletar['Avatar']['isactive'] = 'N';
				$AvatarParaDeletar['Avatar']['id'] = $id;
                
				if($this->Avatar->save($AvatarParaDeletar))
				{
					$this->Session->setFlash(__($this->Mensagens->sucessoDelet), 'default', array('class' => 'success'));
					$this->redirect(array('plugin'=>false, 'controller'=>'profiles', 'action' => 'viewProfile', $AvatarParaDeletar['Avatar']['person_id']));
				}else{
					$this->Session->setFlash(__($this->Mensagens->falhaDelet), 'default', array('class' => 'error'));
					$this->redirect(array('plugin'=>false, 'controller'=>'profiles', 'action' => 'viewProfile', $AvatarParaDeletar['Avatar']['person_id']));
				}
	}
}