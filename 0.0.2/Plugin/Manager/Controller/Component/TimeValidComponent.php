<?php
class TimeValidComponent extends Component{
             
    /**
     * Método que valida a data em formato brasileiro
     */
    public function checkBrDate($date)
    {
          $data= explode('/', $date);
          if(sizeof($data) == 3)
          {
               return $this->checkValidDate($data[0], $data[1], $data[2]); 
          }else{
              return false;
          }  
    }
    
    
    /**
     * Método que retira formato Brasileiro
     */
     public function normalizeFormat($data){
         $data= explode('/', $data);
         return $data[2].'-'.$data[1].'-'.$data[0];
     }
    
    /**
     * Método que valida a data
     */
    public function checkValidDate($day, $month, $year){
        return checkdate ($month , $day , $year);
    }   
}