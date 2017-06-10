<?php
//App::uses('Fornecedor', 'Promotions.Model');
class DetectScreenComponent extends Component{
    
    
    
    public function detect(){
        $teste = '<script type="text/javascript">var variaveljs = screen.width; document.write(variaveljs)</script>';
        pr($teste);
        exit(0);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}