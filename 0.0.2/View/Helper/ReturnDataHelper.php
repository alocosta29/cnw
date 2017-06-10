<?php 
App::uses('AppHelper', 'View/Helper'); 
class ReturnDataHelper extends AppHelper 
{
    
    
    
    public function getNameMailUser($id = null){
         $User = ClassRegistry::init('Manager.User');
         $User->recursive = 0;
         $data = $User->find('first', array('conditions'=>array('User.id'=>$id)));
         $name = 'Não identificado';
         if(!empty($data['User']['username']))
         {
                if(!empty($data['Individual']['nome']))
                {
                    $string = explode(" ", $data['Individual']['nome']);
                    $name = $string[0];
                    if(!empty($string[1])){
                        $name .= ' '.$string[1];
                    }
                }
                $name .= ' ('.$data['User']['username'].')';
             
         }
         return $name;
        
    }
    
    
    public function getBook($book){
        $Caderno = ClassRegistry::init('ConfigBook.Caderno');
        $Caderno->recursive = -1;
        $data = $Caderno->find('first', array('conditions'=>array('Caderno.alias'=>$book, 'Caderno.isdeleted'=>'N')));
        $return = 'Não identificado'; 
        if(!empty($data['Caderno']['nome']))
         {
            $color = $data['Caderno']['cor'];
             $return = '<span style = "color: '.$color.'; ">Caderno de '.$data['Caderno']['nome'].'</span>';
         }
         return $return;
    }
    
    
   public function getNameBook($book){
        $Caderno = ClassRegistry::init('ConfigBook.Caderno');
        $Caderno->recursive = -1;
        $data = $Caderno->find('first', array('conditions'=>array('Caderno.alias'=>$book, 'Caderno.isdeleted'=>'N')));
        $return = false; 
        if(!empty($data['Caderno']['nome']))
         {
       
             $return = $data['Caderno']['nome'];
         }
         return $return;
    }
      
    
    
    
    
    
    
    /**
     * Método que retornao nome dofornecedor
     */
    public function getNameCompanie($person_id)
    { 
         $Companie = ClassRegistry::init('Manager.Companie');
         $name = $Companie->find('first', array('conditions'=>array('Companie.person_id'=>$person_id)));
         if(!empty($name)){
             return $name['Companie']['fantasia'];
         }else{
             return "<br>";
         }   
    }
    
    
    public function getIconProfessional($contactstype_id){
        $Contactstype = ClassRegistry::init('Manager.Contactstype');
        $contact = $Contactstype->findById($contactstype_id);
        switch ($contact['Contactstype']['tipo']) {
            case 'email':
                return 'mail_icon.png';
                break;
            
             case 'telefone':
                return 'tel_icon.png';
                break;
            
            case 'facebook':
                return 'facebook_icon.png';
                break;
            
            case 'linkedin':
                return 'linkedin_icon.png';
                break;  
            
              case 'celular':
                return 'celular_icon.png';
                break;
            
               case 'site':
                return 'site_icon.png';
                break;
            
            
            
            default:
                return '';
                break;
        }
        
        
        
        
    }
    
    
    
}

?>