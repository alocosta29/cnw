<?php 
App::uses('AppHelper', 'View/Helper');

class FormulariosHelper extends AppHelper 
{
    
    /**
     * Método que retorna se a mensagem recebida no 
     * formulário caixinha de sugestões é uma crítica ou sugestão
     */
     public function getTypeSuggestion($alias){
         if($alias == 'cri'){
             return "Crítica";
         }else{
             return "Sugestão";
         }
     } 
    
    
    
    
    
    
    
    
    
}
