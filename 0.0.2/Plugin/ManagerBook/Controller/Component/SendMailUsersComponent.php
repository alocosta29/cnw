<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Cadastro', 'Formularios.Model');
App::uses('Alert', 'Formularios.Model');
App::uses('User', 'Manager.Model');
class SendMailUsersComponent extends Component{
    
    private $limitSend = 3;
    private $type = null;
    private $listSolicitations = null;
    private $listNewUsers = null;
    private $isValidation = true;
    
    public $components = array('SendMail', 'Crypt');
    
    public function start($type = array('A', 'B')){
        $this->cleanClass();
        $this->type = $type;
        $this->sendMails();
        return $this->isValidation;
    }
    
    private function sendMails(){
        
        $i=0;
        $totalSize = sizeof($this->type);
        while($i<$totalSize){
            $this->sendType($this->type[$i]);
            $i++;
        }
        
        
    }
    
    
    private function sendType($type)
    {    
        switch ($type) 
        {
            case 'A':      
                $this->checkSolicitations();
                $this->executeSendMail();
            break;
            case 'B':      
                $this->checkNewUsers();
                $this->executeSendUserMail();
            break;
        
        
        
        
            default:
            break;
        }
    }     
    
    
    
    private function checkNewUsers(){
    
        $User = new User();
        
      /*  $User->unbindModel(array(
            'hasMany' => array('AccessUsers.AccessUser'),
            'hasAndBelongsToMany'=>array('Manager.Role'),
            'belongsTo'=>array('Manager.Person')
            ));*/
        $User->recursive = 1;
        $User->bindModel(array('hasMany' => array('Alert'=>array(
                                        'className' => 'Formularios.Alert',
            'foreignKey' => 'user_id',
                                        'conditions'=>array('Alert.mail_send'=>'Y', 'Alert.type'=>'B')
        ))));
        $find = $User->find('all', 
                array(
                    'conditions'=>array('User.recent_register'=>'Y')));
        
        if(!empty($find)){
            $this->listNewUsers = $find;
        }
    }

    /**
    * Método que verifica as solicitações 
    */
    private function checkSolicitations()
    {

        $Cadastro = new Cadastro();
        $Cadastro->unbindModel(array('hasMany' => array('Formularios.Alert')));
        $Cadastro->bindModel(array('hasMany' => array('Alert'=>array(
                                        'className' => 'Formularios.Alert',
                                        'conditions'=>array('Alert.mail_send'=>'Y', 'Alert.type'=>'A')
        ))));
        $find = $Cadastro->find('all', array( 'conditions' => array('Cadastro.status' => 'A')));
        if(!empty($find))
        {
            $i=0;
            $totalSize = sizeof($find);
            while($i<$totalSize){
                $valid = false;
                if(sizeof($find[$i]['Alert']) < $this->limitSend){
                    $valid = true;
                    $this->listSolicitations = $find;
                }
                $i++;
            }
        }
    }
    
    private function executeSendMail()
    {
        if(!empty($this->listSolicitations)){
                $totalSize = sizeof($this->listSolicitations);
                $i = 0;
                while($i<$totalSize){
                    if($this->checkSend($this->listSolicitations[$i])){
                      $this->saveReturnSend($this->listSolicitations[$i]['Cadastro']['id'], $this->sendMail($this->listSolicitations[$i]['Cadastro']));  
                    }
                    $i++;
                }
        }
    }

    private function executeSendUserMail()
    {
        if(!empty($this->listNewUsers))
        {
            $totalSize = sizeof($this->listNewUsers);
            
            
            $i = 0;
            while($i<$totalSize){
                
                if($this->checkSendUser($this->listNewUsers[$i])){
                  $this->saveReturnSend(false, $this->sendMailUser($this->listNewUsers[$i]), $this->listNewUsers[$i]['User']['id']);  
                }
                $i++;
            }
        }
    }
    
    private function saveReturnSend($cadastro_id = false, $send = false, $user_id = false)
    {
    
        if(!$send){
            $save['Alert']['mail_send'] = 'N';
        }else{
            $save['Alert']['mail_send'] = 'Y';
        }
        if(!empty($cadastro_id)){
            $save['Alert']['cadastro_id'] = $cadastro_id; 
            $save['Alert']['type'] = 'A'; 
        }elseif(!empty($user_id)){
            $save['Alert']['user_id'] = $user_id; 
            $save['Alert']['type'] = 'B';
        }
        $Alert = new Alert();
        $Alert->save($save);
    }
    
    private function checkSend($data)
    {
        $return = true;
        $today = date('Y-m-d');
        if(!empty($data['Alert']))
        {
            $i=0;
            $alertData = $data['Alert'];
            $totalSize = sizeof($alertData);
            if($totalSize < $this->limitSend){
                while($i<$totalSize){
                    if(strtotime($alertData[$i]['created']) == strtotime($today))
                    {
                        $return = false;
                    }
                    $i++;
                }
            }else{
                $return = false;
            }
        }
        return $return;
    }
    
     private function checkSendUser($data)
    {
        $return = true;
        $today = date('Y-m-d');
        if(!empty($data['Alert']))
        {
            $i=0;
            $alertData = $data['Alert'];
            $totalSize = sizeof($alertData);
            if($totalSize < $this->limitSend){
                 while($i<$totalSize){
                    if(strtotime($alertData[$i]['created']) == strtotime($today))
                    {
                        $return = false;
                    }
                    $i++;
                 }
                
            }else{
                $return = false;
            }
            
           
        }
        return $return;
    }
    
    private function sendMail($mailData) {
       $config['mail'] = $mailData['email'];
       $config['nome'] = $mailData['nome'];
       $config['created'] = date('Y-m-d H:i:s');
       $chaveAcesso = $this->Crypt->run($mailData['id']);
       $linkActivate =  HOST_REAL.'activate/'.$chaveAcesso;

       $config['assunto'] = $mailData['nome'].'! Crie seu login de acesso no portal Crescer na Web!';
       $config['mensagem'] = '<strong>Parabéns!</strong><br> A criação do seu login de acesso foi autorizada! '
               . 'Clique no link abaixo para criar sua conta de colunista ou copie e cole o link em seu navegador!<br><br>'
               . '<a href= '.$linkActivate.' target="_blank">'
               . $linkActivate.'</a>';
   
       return $this->SendMail->start($config, false);
    }
    
    
    private function sendMailUser($mailData){
        
       $config['mail'] = $mailData['User']['username'];
       $config['nome'] = $mailData['Individual']['nome'];
       $config['created'] = date('Y-m-d H:i:s');
  
       $link =  HOST_REAL.'admin/';

       $config['assunto'] = $config['nome'].'! Você já pode começar a escrever no portal Crescer na Web!';
       $config['mensagem'] = '<strong>Parabéns!</strong><br> A criação do seu login de acesso foi autorizada! '
               . '<br><br><strong>LOGIN: '.$mailData['User']['username'].'</strong><br>'.
               '<strong>SENHA TEMPORÁRIA(3 primeiros caracteres): '.$this->limitarTexto($mailData['User']['pass_register'], 3).'</strong><br><br>'
               . 'Clique no link abaixo ou copie e cole o link em seu navegador pra começar a escrever agora mesmo!<br><br>'
               . '<a href= '.$link.' target="_blank">'
               . $link.'</a>';
   
       return $this->SendMail->start($config, false);
        
        
    }
    
    public function limitarTexto($texto, $limite, $quebrar = true){
  //corta as tags do texto para evitar corte errado
  $contador = strlen(strip_tags($texto));
  if($contador <= $limite):
    //se o número do texto form menor ou igual o limite então retorna ele mesmo
    $newtext = $texto;
  else:
    if($quebrar == true): //se for maior e $quebrar for true
      //corta o texto no limite indicado e retira o ultimo espaço branco
      $newtext = trim(mb_substr($texto, 0, $limite))."...";
    else:
      //localiza ultimo espaço antes de $limite
      $ultimo_espaço = strrpos(mb_substr($texto, 0, $limite)," ");
      //corta o $texto até a posição lozalizada
      $newtext = trim(mb_substr($texto, 0, $ultimo_espaço))."...";
    endif;
  endif;
  return $newtext;
}
    
    
    
       /**
        * Método que seta os erros encontrados
        * @param type $error
        */
       private function setErrors($error = null)
       {
            $this->isValidation = false;
            if(!empty($this->errors)){
                $this->errors = $this->errors.'<br>'.$error;
            }else{
                $this->errors = $error;
            }
       }
    
    /**
     * Método que limpa a classe
     */
    private function cleanClass()
    {
            $this->isValidation = true;
            $this->listSolicitations = null;  
            $this->listNewUsers = null;
            $this->isValidation = true;
    }
    
    
}