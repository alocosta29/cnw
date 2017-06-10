<?php
App::uses('Ad', 'Monetization.Model');

class SelectAdComponent extends Component{
    
    private $action = null;
    private $params = null;
    private $search = false;
    public $dataContent = null;
    public $options = null;
    public $listConditions = array();
    
    private $isValidation = true;
    public $errors = null;

    
        public function start($action, $listConditions = array()){
        $this->cleanClass();
        $this->action = $action;
        $this->listConditions = $listConditions;
        $this->setBasicParams();
        
        $this->mergeParams();
        
        $this->setSearchParams();
        $this->searchAd(); 
        $this->searchNoFilterAd();
        
        return $this->isValidation;
    } 
    
    
      
   private function setSearchParams(){
        
        switch($this->action)
        {
            case 'home':
           
            break; 
        
            case 'searchPosts':

            break; 
                    
            case 'artigos':
       
            break;
                
            case 'ver_artigo':
                $this->options['limit'] = 2;
                
               
            break;
            
            case 'ver_categoria':

            break;
        
            case 'ver_caderno':
                $this->options['limit'] = 2;
                             

            break;
                      
            case 'colunista':

            break;    
            
            case 'list-colunistas':
      
            break;  
        

            default:
                $this->setErrors('Parâmetros não localizados');
            break;
        }
       
       
       
   }
   
   private function searchAd(){
       if($this->isValidation and !$this->search){
           $Ad = new Ad();
           $Ad->recursive = 0;

           $find = $Ad->find('all', $this->options);
       
           if(!empty($find)){
               $this->search = true;
               $i=0;
               $totalSize = sizeof($find);
               while($i<$totalSize){
                   $this->dataContent[] = $find[$i]['Ad'];
                   $i++;
               }
           }
       }
   }
   
   private function searchNoFilterAd(){
       if($this->isValidation and !$this->search){
            $this->options['conditions'] = array();
            $this->setBasicParams();
            $this->searchAd();
       }
       
   }
   
   
    
   private function setBasicParams(){
       $today = date('Y-m-d H:i:s');
       $this->options['conditions'] = array(
                                                'Ad.isdeleted' => 'N',
                                                'Ad.status' => 'P',
                                                'Ad.data_inicio <= ' => $today,
                                                'Ad.data_fim >= '=> $today

                                            );
       $this->options['order'] = 'rand()';
    
       
   }

private function mergeParams(){
    if(!empty($this->listConditions)){
        $list = $this->listConditions;
        $this->options['conditions'] = array_merge($list['conditions'], $this->options['conditions']);
    }
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
            $this->action = null;
            $this->params = null;
            $this->isValidation = true;
            $this->options = null;
            $this->dataContent = null;
            $this->search = false;
            $this->listConditions = array();
           
     }   
    
}
