<?php
class StringTreatmentComponent extends Component{
    
    private $data = null;
    
    
    public function treatContacts($data = null){
        $this->cleanClass();    
        $this->data = $data;
        $this->normalizeData();
        return $this->data;
    } 
    
    
    private function normalizeData(){
        
        if(!empty($this->data))
        {
            
            $i=0;
            $totalSize = sizeof($this->data);
            while($i<$totalSize){
                unset($this->data[$i]['Person']);
                unset($this->data[$i]['Companie']['Person']);
            
                if(!empty($this->data[$i]['Contact'])){
                    $this->data[$i]['Contact'] = $this->normalizeDataContact($this->data[$i]['Contact']);
                }
                $i++;
            }
            
        }
    }
    
    private function normalizeDataContact($data){
         $i=0;
         $totalSize = sizeof($data);
         
         while($i<$totalSize){
             $dataReturn[$i]['id'] = $data[$i]['id'];
             $dataReturn[$i]['tipo'] = $data[$i]['Contactstype']['tipo'];
             $dataReturn[$i]['label'] = $data[$i]['Contactstype']['label'];
             $dataReturn[$i]['ordem'] = $data[$i]['Contactstype']['ordem'];
             $dataReturn[$i]['contactstype_id'] = $data[$i]['contactstype_id'];
             $dataReturn[$i]['pessoa_paracontato'] = $data[$i]['pessoa_paracontato'];
             $dataReturn[$i]['contato'] = $data[$i]['contato'];
           $i++;  
         }
         return $this->orderByContact($dataReturn);
         
    }
   
   private function orderByContact($dataReturn)
   {
        $totalSize = sizeof($dataReturn);
        if($totalSize>1)
        {
              $i=0;
              $totalSize = sizeof($dataReturn);
              while($i<$totalSize){
                  $listAlpha[$i] = $dataReturn[$i]['ordem'];
                  $i++;
              }
              asort($listAlpha);
              foreach ($listAlpha as $chave => $valor){
                $newlist[] = $dataReturn[$chave];
              }
              $dataReturn = $newlist;
        }
        return $dataReturn;
   }
   
   
    private function cleanClass(){
        $this->data = null;
        
        
    }
    
    
    
    
}
