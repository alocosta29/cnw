<?php
App::import('Formularios.Vendor','WideImage/lib/WideImage');
class ImageComponent extends Component{
    
    private $fileImage= null;
    private $saveFolder = null;
    private $typeAction = null;
 
    private $errors = null;
    private $isValidation = true;

    
   
    
    public function startImage($fileImage, $saveFolder, $typeAction){
        $this->cleanClass();
        $this->fileImage = $fileImage;
        $this->saveFolder = $saveFolder;
        $this->typeAction = $typeAction;
        
        
        
        

        return $this->isValidation;
    }
 
 
 
 
   private function selectAction(){
       $totalSize  = sizeof($this->typeAction);
       $i=0;
       
       while($i < $totalSize){
           switch($this->typeAction[$i]) 
           {
               case 'circle':
                   $this->saveCircle();
                   break;
               
               default:
                   
                   break;
           }
           
           
           
           
           
           
           
           $i++;
       }
       
       
       
       
       
       
   }
 
 
 
 
 
 
 
 
     private function cleanClass()
     {
            $this->fileImage = null;
            $this->saveFolder = null;
            $this->typeAction = null;
            $this->errors = null;
            $this->isValidation = true;
     }
 
 
 
    
}