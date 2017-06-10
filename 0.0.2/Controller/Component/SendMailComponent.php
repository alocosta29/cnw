<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('Configmail', 'Manager.Model');
App::uses('Destinatario', 'Formularios.Model');

class SendMailComponent extends Component{
    private $dataMsg = null;
    private $formatMsg = true;
    private $nameFrom = 'Crescer na Web';
    private $errors = null;
    private $senderConfig =null;
    private $addresseeConfig = null;
    private $emailAddresse = null;
    private $cc = false;
    private $cco = false;
    private $attachFile = false;  
    private $isValidation = true;
    
    //public $components = array('Remetente');
    public function startSend($dataMsg, $file = false, $formatMsg = true){
      $this->cleanClass();  
      $this->dataMsg = $dataMsg;
      $this->formatMsg = $formatMsg;
      $this->setSenderConfig();
      $this->setAddressee();  
      $this->attachFile = $file;
      $this->sendMail();

      return $this->isValidation;  
    }
    
    public function start($dataMsg, $formatMsg = true){
      $this->cleanClass();  
      $this->dataMsg = $dataMsg;
      $this->formatMsg = $formatMsg;
      $this->setSenderConfig(); 
      $this->configSendPerson();
      $this->sendMail();
      return $this->isValidation;  
    }
    
    
    private function configSendPerson(){
        if(!empty($this->dataMsg['mail'])){
            $this->emailAddresse = $this->dataMsg['mail'];
            if(!empty($this->dataMsg['cc'])){
               $this->cc = $this->dataMsg['cc'];
            }
            if(!empty($this->dataMsg['cco'])){
               $this->cco = $this->dataMsg['cco'];
            }
            $this->dataMsg['email'] = $this->senderConfig['from'];
            if(!empty($this->dataMsg['name-from'])){
                $this->nameFrom = $this->dataMsg['name-from'];
                
            }
            
            
        }else{
            $this->setErrors('Destinatário não localizado!');
        }
    }
    

    /**
          * Método que seta o remetente
          */
    private function setSenderConfig()
    {
          $Configmail = new Configmail(); 
          $find = $Configmail->find('first', array('conditions'=>array('Configmail.isdeleted'=>'N')));
          if(!empty($find))
          {
               $this->senderConfig = $find['Configmail'];
          }else{
               $this->setErrors('O email não está configurado! Consulte o administrador do site!');
          }
    }
    
    /**
     * Método que seta os destinatários
     */
    private function setAddressee(){
        if($this->isValidation)
        {
             $Destinatario = new Destinatario();
             $find = $Destinatario->find('first', array('conditions'=>array('Destinatario.formulario_id'=>$this->dataMsg['formulario_id'])));
             $email = $this->checkEmailList($find['Destinatario']['mail']);
             if($email)
             {
                 $this->emailAddresse = $email;
                 if(!empty($find['Destinatario']['cc']))
                 {
                    $this->cc = $this->checkEmailList($find['Destinatario']['cc']);
                 } 
                 if(!empty($find['Destinatario']['cco']))
                 {
                    $this->cco = $this->checkEmailList($find['Destinatario']['cco']);
                 } 
             }else{
                 $this->setErrors('Email destinatário não configurado! Por favor, procure o administrador do sistema! ');
             }
        }
    }
    
    private function sendMail()
    {       
        if($this->isValidation)
        {            
            try{
                $this->senderConfig['from'] = array($this->senderConfig['from'] => $this->nameFrom);
        
                    $this->email = new CakeEmail($this->senderConfig);
                    $this->email->to($this->emailAddresse);
                            
                    if($this->cc){
                        $this->email->cc($this->cc);      
                    }
                    if($this->cco){
                        $this->email->bcc($this->cco);    
                    }
                    if($this->attachFile){
                        $this->email->attachments(array($this->attachFile));
                    }
                    $this->email->subject($this->dataMsg['assunto']);
                    if(!$this->email->send($this->getMsg()))
                            throw new Exception();
            }catch(Exception $e){
                    $this->setErrors('Erro desconhecido! Não foi possível enviar o email! ');
            } 
        }
    }
    

    
    
    
    
    
    
    
    
    private function getMsg(){
        
        
        if($this->formatMsg){
            $msg = '<strong>Nome:</strong> '.$this->dataMsg['nome'].'<br>';
            $msg .= '<strong>Assunto:</strong> '.$this->dataMsg['assunto'].'<br>';
            $msg .= '<strong>Dia/hora:</strong> '.date('d/m/Y H:i:s', strtotime($this->dataMsg['created'])).'<br>';
             if(!empty($this->dataMsg['tel'])){
               $msg .= '<strong>Telefone:</strong> '.$this->dataMsg['tel'].'<br>'; 
            }
            $msg .= '<strong>Email:</strong> '.$this->dataMsg['email'].'<br>';
            $msg .= '<strong>Mensagem:</strong> '.$this->dataMsg['mensagem'].'<br>';
            
        }else{
            $msg = $this->dataMsg['mensagem'];
        }
    
        return $msg;
    }
    
    public function enviarEmail($assunto, $msg, $mail, $cc, $cco, $file=false)
    {
            $mail = $this->checkEmailList($mail);
            $cc = $this->checkEmailList($cc);
            $cco = $this->checkEmailList($cco);
            $remetente =  $this->Remetente->retornaRemetente();           
            pr($remetente); exit(0);
        try{
                    $this->email = new CakeEmail($remetente);
                    $this->email->subject($assunto);
                    $this->email->to($mail);
                    if($cc <> false){
                        $this->email->cc($cc);      
                    }
                    if($cco <> false){
                        $this->email->bcc($cco);    
                    }
                    if($file <> false){
                        $this->email->attachments(array($file));
                    }
                    if(!$this->email->send($msg))
                            throw new Exception();
                    return true;
            }catch(Exception $e){
                    return false;
            }   
        }
    
    /**
     * Método que normaliza os e-mails
     */
    private function checkEmailList($email)
    {   
        $email = str_replace(' ', '', $email);
        $email = str_replace(';', ',', $email);
        $checkVirgula = strpos($email, ",");
        $returnMail = false;
        if($checkVirgula === false){
            $returnMail[0] = $email;
        }else{
            $listMail = explode(",", $email);
            $returnMail = $listMail;  
        }
        return $returnMail;
    }
        
    public function getErrors(){
        return $this->errors;
    }
         /**
     * Método que seta possíveis erros
     */
    private function setErrors($error){
        $this->isValidation = false;
        if(!empty($this->errors)){
            $this->errors = $this->errors .'<br>'.$error;
        }else{
            $this->errors = $error;
        }
    }   
    
   private function cleanClass()
   {
       $this->dataMsg = null;
       $this->errors = null;
       $this->senderConfig = null;
       $this->addresseeConfig = null; 
       $this->emailAddresse = null;
       $this->cc = false;
       $this->cco = false;
       $this->attachFile = false;
       $this->isValidation = true;
   }    
}