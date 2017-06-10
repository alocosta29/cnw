<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('ManagerBookAppController', 'ManagerBook.Controller');
class ManagerUsersController extends ManagerBookAppController{
public $uses = array(   'Manager.Person', 'Manager.User', 'Manager.Individual', 'ManagerBook.Colunista', 'Manager.User', 
                        'Manager.RolesUser', 'AccessUsers.AccessUser', 'AccessUsers.AccessCaderno', 'Formularios.CadastrosCaderno', 'Formularios.Cadastro');
public $components = array('ManagerBook.PermissionBook', 'Manager.CheckProfileData', 'ManagerBook.AllowDenyBook', 'ManagerBook.SendMailUsers');

public function beforeFilter() 
{
    parent::beforeFilter();
    if(($this->action == 'admin_addUser') and !isset($this->params['pass'][1])){
        $this->redirect(array('action'=>'checkCpf', $this->params['pass'][0]));        
    }
}

/**
 * Método que cadastra colunista
 */
public function admin_addUser($caderno = null, $cpf = null)
{
  if($this->Session->read('Auth.User.addUser') == $cpf)
  {
        $nome = false;
        $person_id = false;
        $username = false;
        $this->Individual->recursive = 1;
        $find = $this->Individual->find('first', array('conditions' => array('Individual.cpf' => $cpf)));
        if(!empty($find)){
            $nome = $find['Individual']['nome'];
            $person_id = $find['Individual']['person_id'];
            if(!empty($find['User']['username'])){
                $username = $find['User']['username'];
            }
        }
        if($this->request->is('post'))
        {
                $data = $this->request->data;
                $data['Person']['tipo_pessoa'] = 'F';
                $data['Individual'][0]['cpf'] = $this->Session->read('Auth.User.addUser');
                $data['User'][0]['pass_register'] = 'cnw'.date('mY');
                $data['User'][0]['password'] = $data['User'][0]['pass_register'];
                if($this->CheckProfileData->startCheck($data))
                {
                            $data = $this->CheckProfileData->getData();
                            $datasource = $this->Person->getDataSource();
                        try{
                                    $datasource->begin();
                                    
                                    if(!$person_id)
                                    {
                                           #pr('$data'); exit(0);
                                           //sem essa dissociação, o cadastro não funciona
                                           $this->Individual->unbindModel(
                                               array('belongsTo' => array('User'))
                                           );
                                           $this->Person->create();
                                           if(!$this->Person->saveAll($data)){
                                               throw new Exception();				
                                           }
                                           $person_id = $this->Person->id; 
                                    }else{
                                        $saveInd['Individual'] = $data['Individual'][0];
                                        $saveUser['User'] = $data['User'][0];
                                        $saveCol['Colunista'] =  $data['Colunista'][0];
                                        if(!$this->Individual->save($saveInd)){
                                                throw new Exception();				
                                        }
                                        if(!$this->User->save($saveUser)){
                                            throw new Exception();				
                                        }
                                        if(!$this->Colunista->save($saveCol)){
                                            throw new Exception();				
                                        }
                                    }
                                    $datasource->commit();
                                    $this->Session->delete('Auth.User.addUser');
                                    $this->Session->setFlash(__($this->Mensagens->sucessoAdd), 'default', array('class' => 'success'));
                                    $this->redirect(array('action' => 'viewProfile', $caderno, $person_id));
                            }catch(Exception $e){
                                    $datasource->rollback();
                                    $this->Session->setFlash(__($this->Mensagens->falhaAdd), 'default', array('class' => 'error'));
                            }
                }else{
                    $this->Session->setFlash(__($this->CheckProfileData->errors), 'default', array('class' => 'error'));
                }              
          }
          $this->set('nome', $nome);
          $this->set('username', $username);
          $this->set('caderno', $caderno);
  }else{
        $this->Session->delete('Auth.User.addUser');
        $this->Session->setFlash(__('CPF não localizado'), 'default', array('class' => 'error'));
        $this->redirect(array('action'=>'checkCpf', $caderno));  
  } 
}
    
/**
 * Método que verifica se o e-mail já existe na base de dados
 * @param type $caderno
 */
public function admin_checkCpf($caderno)
{
    if($this->request->is('post'))
    {
        $data = $this->request->data;
        $cpf = preg_replace("/[^0-9]/i", "", $data['Individual']['cpf']);
        if($this->CheckData->checkCPF($cpf))
        {
            $this->Individual->recursive = 1;
            $find = $this->Individual->find('first', array('conditions' => array('Individual.cpf' => $cpf)));
            if(!empty($find['User']['username']))
            {
                $this->redirect(array('action' => 'viewProfile', $caderno, $find['Individual']['person_id']));
            }else{
                $this->Session->write('Auth.User.addUser', $cpf);
                $this->redirect(array('action' => 'addUser', $caderno, $cpf));
            }
        }else{
            $this->Session->setFlash(__('CPF inválido'), 'default', array('class' => 'error'));
        }
    }
    $this->set('caderno', $caderno);
}

public function admin_viewProfile($caderno = null, $id = null)
{
    if($this->PermissionBook->start($id, $caderno))
    {
        
        # pr($this->PermissionBook->dataUser); exit(0);
        $this->set('profile', $this->PermissionBook->dataUser);
        $this->set('book', $caderno);
        $this->set('caderno', $caderno);
    }else{
        $this->Session->setFlash(__('Perfil não localizado!'), 'default', array('class' => 'error'));
        $this->redirect(array('plugin' => 'manager', 'controller' => 'users', 'action' => 'index'));
    }    
}


public function admin_requests($caderno = null)
{
        
    	$options = array(
                    'conditions'=>array(
                                        'Caderno.alias'=>$caderno,
                                        'Cadastro.status'=>'N'
                        ));
		$this->paginate = $options;
		$Models = $this->paginate('CadastrosCaderno');
		$this->set('list', $Models);
        $this->set('caderno', $caderno);
}

/**
 * Método que lista os usuários com solicitações pendentes de acesso ao caderno
 */
public function admin_outstanding($caderno = null){

      
        $options = array(

            'fields'=>array('Cadastro.nome', 'Cadastro.email', 'CadastrosCaderno.status', 'CadastrosCaderno.id'),
            'conditions'=>array(
                                'Caderno.alias'=>$caderno,
                                'CadastrosCaderno.status' => 'P', 
                        
                                ),
            'order'=>array('CadastrosCaderno.id'=>'DESC'),
            'limit'=>25
        ); 
   // $this->CadastroCaderno->recursive = -1; 
    $this->paginate = $options;
    $report = $this->paginate('CadastrosCaderno');
   $this->set('caderno', $caderno); 
   $this->set('reports', $report); 
}


public function admin_allowOutstanding($caderno = null, $id = null)
{
   $query = " SELECT Caderno.alias, CadastrosCaderno.id, Cadastro.nome, Cadastro.person_id, User.id as user_id 
            FROM cwcol_cadastros_cadernos AS CadastrosCaderno
            LEFT JOIN cw_cadernos AS Caderno
            ON Caderno.id = CadastrosCaderno.caderno_id
            LEFT JOIN cwcol_cadastros AS Cadastro
            ON Cadastro.id = CadastrosCaderno.cadastro_id
            INNER JOIN users as User
            ON Cadastro.person_id = User.person_id
            WHERE 
            CadastrosCaderno.status = 'P'
            ";

    $query .= "AND 
            CadastrosCaderno.id = ".$id;
    $find = $this->CadastrosCaderno->query($query);
  
    if(!empty($find[0]['User']['user_id']))
    {
               $find = $find[0];
               if($this->AllowDenyBook->start($find['Caderno']['alias'], 'col', $find['User']['user_id']))
               {
                    $dataSave = $this->AllowDenyBook->dataSave;
                    $dataSave['User']['type_register'] = 'S';
                    
                      $datasource = $this->User->getDataSource();
                    try{
                        $datasource->begin();

                        if(!empty($dataSave['User'])){
                             $user['User'] = $dataSave['User'];
                             if(!$this->User->save($user, array('validate'=>false))){
                             throw new Exception(); }
                        }

                        if(!empty($dataSave['RolesUser'])){
                            $roles['RolesUser'] = $dataSave['RolesUser'];
                             if(!$this->RolesUser->save($roles)){
                             throw new Exception(); }
                        }

                        if(!empty($dataSave['AccessUser'])){
                            $access['AccessUser'] = $dataSave['AccessUser'];
                             if(!$this->AccessUser->save($access)){
                             throw new Exception(); }
                        }

                        if(!empty($dataSave['AccessCaderno'])){
                            $cader['AccessCaderno'] = $dataSave['AccessCaderno'];
                             if(!$this->AccessCaderno->save($cader)){
                             throw new Exception(); }
                        }
                        
                        if(!$this->CadastrosCaderno->updateAll(
                                array('CadastrosCaderno.status' => "'A'"),
                                array('CadastrosCaderno.id' => $find['CadastrosCaderno']['id'])
                            )){
                                          throw new Exception();               
                       }	

                        $datasource->commit();
                        $this->Session->setFlash(__('Permissões configuradas com sucesso! '), 'default', array('class' => 'success'));
                         $this->redirect(array('action'=>'outstanding', $caderno));
                    }catch(Exception $e){
                        $datasource->rollback();
                        $this->Session->setFlash(__('As permissões não foram configuradas com sucesso! Por favor, tente novamente! '), 'default', array('class' => 'error'));
                        $this->redirect(array('action'=>'outstanding', $caderno));
                    }
                }else{
                     $this->Session->setFlash(__($this->AllowDenyBook->errors), 'default', array('class' => 'error'));
                     $this->redirect(array('action'=>'outstanding', $caderno));
                }   
        
        
        
    }else{
        $this->Session->setFlash(__('Registro não localizado'), 'default', array('class' => 'error'));
        $this->redirect(array('action'=>'outstanding', $caderno));
    }
}

public function admin_denyOutstanding($caderno = null, $id = null)
{
    $datasource = $this->CadastrosCaderno->getDataSource();
    try{
            $datasource->begin();
            if(!$this->CadastrosCaderno->updateAll(
                                    array('CadastrosCaderno.status' => "'R'"),
                                    array('CadastrosCaderno.id' => $id, 'CadastrosCaderno.status' =>'P')
                                ))
            {
                throw new Exception();               
            }				
            $datasource->commit();
            $this->Session->setFlash(__('Operação completada com sucesso!'), 'default', array('class' => 'success'));
            $this->redirect(array('action'=>'outstanding', $caderno));
    }catch(Exception $e){
            $datasource->rollback();
            $this->Session->setFlash(__('Não foi possível completar a operação. Por favor, tente novamente!'), 'default', array('class' => 'error'));
            $this->redirect(array('action'=>'outstanding', $caderno));
    }
}


public function admin_allowBook($caderno, $type, $id)
{
    if($this->AllowDenyBook->start($caderno, $type, $id))
    {
         $dataSave = $this->AllowDenyBook->dataSave;
         $datasource = $this->User->getDataSource();
         try{
             $datasource->begin();

             if(!empty($dataSave['User'])){
                  $user['User'] = $dataSave['User'];
                  if(!$this->User->save($user, array('validate'=>false))){
                  throw new Exception(); }
             }

             if(!empty($dataSave['RolesUser'])){
                 $roles['RolesUser'] = $dataSave['RolesUser'];
                  if(!$this->RolesUser->save($roles)){
                  throw new Exception(); }
             }

             if(!empty($dataSave['AccessUser'])){
                 $access['AccessUser'] = $dataSave['AccessUser'];
                  if(!$this->AccessUser->save($access)){
                  throw new Exception(); }
             }

             if(!empty($dataSave['AccessCaderno'])){
                 $cader['AccessCaderno'] = $dataSave['AccessCaderno'];
                  if(!$this->AccessCaderno->save($cader)){
                  throw new Exception(); }
             }

             $datasource->commit();
             $this->Session->setFlash(__('Permissões configuradas com sucesso! '), 'default', array('class' => 'success'));
             $this->redirect($this->referer());
         }catch(Exception $e){
             $datasource->rollback();
             $this->Session->setFlash(__('As permissões não foram configuradas com sucesso! Por favor, tente novamente! '), 'default', array('class' => 'error'));
             $this->redirect($this->referer());
         }
     }else{
          $this->Session->setFlash(__($this->AllowDenyBook->errors), 'default', array('class' => 'error'));
          $this->redirect($this->referer());
     }   
}


/**
 * Autoriza o acesso do usuário ao sistema
 * @param type $caderno
 * @param type $id
 */
public function admin_autorizeRequest($caderno = null, $id = null)
{
    $find  = $this->Cadastro->find('first', 
            array('conditions'=>array('Cadastro.id'=>$id, 'Cadastro.status'=>'N')));
    if(!empty($find['Cadastro']))
    {
        $datasource = $this->Cadastro->getDataSource();
        try{
            $datasource->begin();
            $save['Cadastro']['id'] = $id;
            $save['Cadastro']['status'] = 'A';
            if(!$this->Cadastro->save($save)){
                throw new Exception();		
            }		
            $datasource->commit();
            $this->Session->setFlash(__('Solicitação autorizada com sucesso!'), 'default', array('class'=>'success'));
            $this->redirect(array('action' => 'requests', $caderno));
            
        }catch(Exception $e){
          $datasource->rollback();
          $this->Session->setFlash(__('Solicitação não pode ser autorizada. Por favor, tente novamente!'), 'default', array('class'=>'error'));
          $this->redirect(array('action' => 'requests', $caderno));  
        }
        
    }else{
        $this->Session->setFlash(__('Solicitação não localizada!'), 'default', array());
        $this->redirect(array('action' => 'requests', $caderno));
    }
    
}
    /**
 * Autoriza o acesso do usuário ao sistema
 * @param type $caderno
 * @param type $id
 */
public function admin_denyRequest($caderno = null, $id = null)
{
    $find  = $this->Cadastro->find('first', 
            array('conditions'=>array('Cadastro.id'=>$id, 'Cadastro.status'=>'N')));
    if(!empty($find['Cadastro']))
    {
        $datasource = $this->Cadastro->getDataSource();
        try{
            $datasource->begin();
            $save['Cadastro']['id'] = $id;
            $save['Cadastro']['status'] = 'R';
            if(!$this->Cadastro->save($save)){
                throw new Exception();		
            }		
            $datasource->commit();
            $this->Session->setFlash(__('Solicitação negada com sucesso!'), 'default', array());
            $this->redirect(array('action' => 'requests', $caderno));
            
        }catch(Exception $e){
          $datasource->rollback();
          $this->Session->setFlash(__('A solicitação não pode ser negada. Por favor, tente novamente!'), 'default', array());
          $this->redirect(array('action' => 'requests', $caderno));  
        }
        
    }else{
        $this->Session->setFlash(__('Solicitação não localizada!'), 'default', array());
        $this->redirect(array('action' => 'requests', $caderno));
    }  
}






/**
 * Método que retirar a permissão de caderno do usuário selecionado
 * @param type $caderno
 * @param type $type
 * @param type $id
 * @throws Exception
 */
public function admin_denyBook($caderno, $type, $id)
{
    if($this->AllowDenyBook->start($caderno, $type, $id, false))
    {
         $dataSave = $this->AllowDenyBook->dataSave;
         
         $datasource = $this->User->getDataSource();
         try{
             $datasource->begin();

             if(!empty($dataSave['User'])){
                  $user['User'] = $dataSave['User'];
                  if(!$this->User->save($user, array('validate'=>false))){
                  throw new Exception(); }
             }

             if(!empty($dataSave['RolesUser'])){
                 $roles['RolesUser'] = $dataSave['RolesUser'];
                  if(!$this->RolesUser->delete($roles['RolesUser']['id'])){
                  throw new Exception(); }
             }

             if(!empty($dataSave['AccessUser'])){
                 $access['AccessUser'] = $dataSave['AccessUser'];
                 if(!$this->AccessUser->updateAll(
                                                $access['AccessUser']['set'],
                                                $access['AccessUser']['conditions']
                )){ throw new Exception(); }
             }

             if(!empty($dataSave['AccessCaderno'])){
                 $cader['AccessCaderno'] = $dataSave['AccessCaderno'];
                 if(!$this->AccessCaderno->updateAll(
                                            $cader['AccessCaderno']['set'],
                                            $cader['AccessCaderno']['conditions']
                )){ throw new Exception();  }
             }

             $datasource->commit();
             $this->Session->setFlash(__('Permissões retiradas com sucesso! '), 'default', array('class' => 'success'));
             $this->redirect($this->referer());
         }catch(Exception $e){
             $datasource->rollback();
             $this->Session->setFlash(__('As permissões não foram retiradas com sucesso! Por favor, tente novamente! '), 'default', array('class' => 'error'));
             $this->redirect($this->referer());
         }
     }else{
          $this->Session->setFlash(__($this->AllowDenyBook->errors), 'default', array('class' => 'error'));
          $this->redirect($this->referer());
     }   
}


/**
 * Método que lista colunistas do 
 * @param type $caderno
 */
public function admin_listUsers($caderno = null)
{
        $this->AccessCaderno->recursive = 1;
        $options = array(
        'fields'=>array('User.username', 'User.id', 'User.person_id', 'AccessCaderno.created', 'AccessCaderno.autorizeby'),    
        'conditions' => array(
            'AccessCaderno.isactive' => 'Y',
            'AccessCaderno.type'=>'col',
            'Caderno.alias' => $caderno,
            'User.status'=>1
            ),
        'order' => array('AccessCaderno.id' => 'DESC'),
        'limit' => 20
		);
		$this->paginate = $options;
		$AccessCadernos = $this->getName($this->paginate('AccessCaderno'));
        #pr($AccessCadernos); exit(0);
        $this->set('list', $AccessCadernos);  
        $this->set('caderno', $caderno);
} 

/**
 * Método que completa os dados do array com informações
 * @param type $data
 */
private function getName($data){
    $i=0;
    $totalSize = sizeof($data);
    while($i<$totalSize){
        $data[$i]['User']['nome'] = $this->getNameIndividual($data[$i]['User']['id']);
        $data[$i]['AccessCaderno']['autorizebyname'] = $this->getNameIndividual($data[$i]['AccessCaderno']['autorizeby']);
        $i++; 
    }
    return $data;
}


private function getNameIndividual($user_id = null){
    $this->User->recursive = 0;
    $find = $this->User->find('first', array('conditions'=>array('User.id'=>$user_id)));
    if(!empty($find['Individual']['nome'])){
        return $find['Individual']['nome'];
    }else{
        return null;
    }
}





    
}