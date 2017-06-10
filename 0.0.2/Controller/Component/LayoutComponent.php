<?php
define('CNW_VERSION', '0.0.2');
define('SYS', 'CNW');
class LayoutComponent extends Component {
	
	public function getLayout($plugin = false, $controller, $action )
    {
   
            //fim de provisorio
           $checkAction = strpos($action, 'admin_');
           if($checkAction === false)
           {
              
                switch ($controller) 
                {
                      case 'pages':
                          return 'PublicLayout.publicLayout'; 
                      break;

                      case 'public':
                       #   return 'AdmLayout.sgpLayout';
                          return $this->getPublicLayout($action); 
                      break;

                  
                      case 'history':
                           return 'AdmLayout.sgpLayout';
                      break;
                  
                      default:
                          return 'PublicLayout.publicLayout'; 
                      break;
                }
           }else{
                if($action == 'admin_login')
                {
                   return 'LoginLayout.layoutLogin';
                }elseif($action == 'admin_previewPost'){
                   return 'PublicLayout.layoutBook'; 
                }else{
                   return 'AdmLayout.sgpLayout';
                }
           }
	}
        
    private function getPublicLayout($action)
    {
        switch($action)
        {
              case 'caderno':
                  return 'PublicLayout.layoutBook';     
              break;

              case 'artigo':
                  return 'PublicLayout.layoutBook';     
              break;

              case 'categoria':
                  return 'PublicLayout.layoutBook';     
              break;
          
           case 'download':
                  return 'PublicLayout.layoutBook';     
              break;

               default:
                  return 'PublicLayout.publicLayout';  
               break;
           }
    }

    private function getLayoutAdmin($action)
    {
        switch ($action) {
            case 'admin_login':
                return 'Layout.loginLayout';
                break;

            default:
                //return 'Layout.administrador2';
                return 'Layout.layoutFlat';
                break;
        }
    }
}	