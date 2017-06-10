<?php
/**
 * Componente que verifica permissões especiais
 */
App::uses('AccessUser', 'AccessUsers.Model');
App::uses('AccessCaderno', 'AccessUsers.Model');
App::uses('Package', 'ManagerPackages.Model');
class CheckPermissionComponent extends Component{
    
    public $components = array('Session');
    
    /**
     *Plugin que o usuário está tentando acessar
     */
    private $plugin = null;
    
    /**
     *Parâmetro do método que o usuário está tentando acessar
     */
    private $pass = null;    
    
    /**
     *Lista de plugin controlados por usuário
     */
    private $listPluginsControluser = array();            
    
    /**
     *Id do usuário logado
     */
    private $user = false;
    
    /**
     * Lista de plugins das quais o usuário possui acesso
     */
    private $pluginPermissions = false;
    
    /**
     *lista de cadernos que o usuário possui acesso de colunista
     */
    private $pp_cols = false;
    
    /*
     * lista de cadernos que o usuário possui acesso de moderador
     */
    private $pp_adm = false;
    
    
       /**
     *lista de cadernos que o usuário possui acesso de moderação de anuncios
     */
    private $adMod = false;
    
    /*
     * lista de cadernos que o usuário possui acesso para portagem de anuncios
     */
    private $adPub = false;
    
    
    
    /**
     *Variavel que informa se o plugin é controlado por usuário ou não
     */
    private $isControleUser = false;            
          
    /**
     *Variavel que informa se o acesso do usuário ao plugin é permitido
     */
    public $pluginAllow = false;
    
     /**
     * Método que cverifica se o plugin é controlado por usuário
     * @param type $plugin
     */
   public function checkUserControl($plugin = null, $pass = null)
   {
      $this->cleanClass();
      $this->setPlugin($plugin);
      $this->setPackages(); 
      $this->checkTypeControl();
      $this->setUser(); 
      $this->setMenu();
      if(in_array($this->plugin, $this->listPluginsControluser)){
        
          if(!empty($pass)){
              $this->pass = $pass[0];
          }
          $this->checkPermission();
      }

      return $this->isControleUser;
   }
    
   /**
    * Método que seta os plugins dos quais o acesso é controlados por usuário
    * @return type
    */ 
    private function setPackages(){
       $Package = new Package();
       $Package->recursive =-1;
       $find = $Package->find('list', array(
           'fields'=>array('Package.id', 'Package.plugin'),
           'conditions'=>array(
                                'Package.isdeleted'=>'N',
                                'Package.isactive'=>'Y',
                            )));
        if(!empty($find))
        {
            sort($find);
            $i=0;
            $totalSize = sizeof($find);
    
            while($i<$totalSize){
                $this->listPluginsControluser[$i] = $this->noSpecials($find[$i]);
                $i++;
            }
        }
    }
    
    /**
     * Método que verifica se o plugin possui controle de acesso por usuário, e não por grupo
     */
    private function checkTypeControl(){
        if(!empty($this->plugin)){
            if(in_array($this->plugin, $this->listPluginsControluser)){
                $this->isControleUser = true;
            }
        }
    }

    /**
     * Método que seta o menu na sessão
     * @return type
     */
    private function setMenu()
    {
        if(!empty($this->listPluginsControluser) and $this->user)
        {
            $AccessUser = new AccessUser();
            $AccessUser->recursive = 0;
            $find = $AccessUser->find('all', array(
                'fields'=>array('Package.plugin'),
                'conditions'=>array(
                          'AccessUser.user_id'=>$this->user,
                          'AccessUser.isactive'=>'Y',
                )));

            if(!empty($find))
            {
                $i=0;
                $totalSize = sizeof($find);
                while($i<$totalSize){
                    $this->pluginPermissions[$i] = $this->noSpecials($find[$i]['Package']['plugin']);
                    $this->setMenuParameters($this->pluginPermissions[$i]);
                $i++;    
                }
            }
        }
    }
    

    
    /**
     * Seta o plugin sme caracteres especiais e em letras minúsculas
     * @param type $plugin
     */
    private function setPlugin($plugin){
        if(!empty($plugin)){
            $this->plugin = $this->noSpecials($plugin);
        }        
    }
    
    /**
     * Método que seta o usuário na memória da classe
     */
    private function setUser(){
      if($this->Session->read('Auth.User.id')){
          $this->user = $this->Session->read('Auth.User.id');
      }
    }
    
    /**
     * Método que seta as permissões especiais na memória da classe
     */
    private function setEspecialPermissions(){
        $AccessUser = new AccessUser();
        $AccessUser->recursive = 0;
        $find = $AccessUser->find('all', 
                                          array(
                                                'fields'=>array('Package.plugin'),
                                                'conditions'=>array(
                                                          'AccessUser.user_id'=>$this->user,
                                                          'AccessUser.isactive'=>'Y',
                                                )));
        if(!empty($find))
        {
            $i=0;
            $totalSize = sizeof($find);
            while($i<$totalSize)
            {
                $this->pluginPermissions[$i] = $this->noSpecials($find[$i]['Package']['plugin']);
                $this->checkParametersPermissions($this->pluginPermissions[$i]);
                $i++;    
            }
        }
    }
    
    /**
     * Seta na sessão do usuário os pacotes que o mesmo possui acesso
     */
    private function setPluginPermissionsSession(){
        $this->Session->write('Auth.User.specialAccess.packages', $this->pluginPermissions);        
    }
    
    /**
     * Método que verifica se o usuário possui acesso especial ao plugin que tenta acessar
     */
    private function checkPermission(){

        if(in_array($this->plugin, $this->pluginPermissions)){
            return $this->checkParametersPermissions($this->plugin);
        }
    }

    /**
     * Método que limpa os caracteres especiais do texto, bem como transforma em letras minúsculas 
     * @param type $texto
     * @return type
     */
    private function noSpecials($texto)
    {
        $texto = trim(html_entity_decode($texto));
        $texto= preg_replace('![áàãâä]+!u','a',$texto);
        $texto= preg_replace('![éèêë]+!u','e',$texto);
        $texto= preg_replace('![íìîï]+!u','i',$texto);
        $texto= preg_replace('![óòõôö]+!u','o',$texto);
        $texto= preg_replace('![úùûü]+!u','u',$texto);
        $texto= preg_replace('![ç]+!u','c',$texto);
        $texto= preg_replace('![ñ]+!u','n',$texto);
        $texto= preg_replace('[^a-z0-9\-]','-',$texto);
        $texto = str_replace('-','',$texto);
        $texto = str_replace(' ','',$texto);
        $texto = str_replace('_','',$texto);
        $texto = str_replace('--','-',$texto);
        return strtolower($texto);
    }
    
    /**
     * Método especial que verifica os parametros de permissão
     */
    private function setMenuParameters($plugin = false)
    {
            switch($plugin) 
            {
                case 'managerbook':
                     $this->setMenuBooks('adm');
                 
                break;
            
                case 'articles':
                     $this->setMenuBooks('col');   
                break;
            
                case 'managerads':
                         $this->setMenuBooks('ads');   
                break;

                case 'createads':
                     $this->setMenuBooks('cad');   
                break;

                default:
                break;
            }
    }
    
    /**
     * Método que seta os parâmetros para a geração dos links de colunistas e moderadores
     */
    private function setMenuBooks($type){
        $AccessCaderno = new AccessCaderno();
        $AccessCaderno->recursive = 0;
        $find = $AccessCaderno->find('all', 
           array('conditions'=>array(
                                        'AccessCaderno.user_id'=>$this->user,
                                        'AccessCaderno.isactive'=>'Y',
                                        'AccessCaderno.type'=>$type
                                     )));
        if(!empty($find))
        {
            $i=0;
            $totalSize = sizeof($find);
            while($i<$totalSize)
            {
                $parameter = $find[$i]['Caderno']['alias'];
                 if($type == 'col')
                 {
                    $this->pp_cols[$i] = $parameter; 
                 }elseif($type == 'adm'){
                    $this->pp_adm[$i] = $parameter;
                 }elseif($type == 'ads'){
                     
                     $this->adMod[$i] = $parameter;
                 }elseif($type == 'cad'){
                     $this->adPub[$i] = $parameter;
                     
                 }
                $i++;    
            }
            if($type == 'col')
            {
                $this->Session->write('Auth.User.specialAccess.book_col', $this->pp_cols);
            }elseif($type == 'adm')
            {
                $this->Session->write('Auth.User.specialAccess.book_adm', $this->pp_adm);
            }elseif($type == 'ads')
            {
                $this->Session->write('Auth.User.specialAccess.ads_adm', $this->adMod);
            }elseif($type == 'cad')
            {
                $this->Session->write('Auth.User.specialAccess.ads_pub', $this->adPub);
            }
            
            
            
            
        }        
    }
    
    
    
     /**
     * Método especial que verifica os parametros de permissão
     */
    private function checkParametersPermissions($plugin = false)
    {
            switch($plugin) 
            {
                case 'managerbook':
                    $this->checkPermissionArticles($this->pass, $this->pp_adm);

                break;
            
                case 'articles':
                    $this->checkPermissionArticles($this->pass, $this->pp_cols);
                break;

                default:
                    $this->pluginAllow = true;
                break;
            }
    }
    
    
    /**
     * Método que verifica a permissão de colunistas e moderadores para o caderno seleiconado
     */
    private function checkPermissionArticles($pass = null, $list = array())
    {

        if(!empty($pass)){
            if(in_array($pass, $list)){
                 $this->pluginAllow = true;
            }
        }        
    }
    
    /*
     * Método que verifica se o usuário possui permissão de acesso ao caderno
     */
    private function checkPermissionParameters($pass, $type){
        if(!empty($pass))
        {
            sort($pass);
            if($type == 'col'){
                $parametersPermissions = $this->pp_cols;  
            }elseif($type == 'adm'){
                $parametersPermissions = $this->pp_adm;  
            }
         
            if(!in_array($pass[0], $parametersPermissions))
            {
                $this->isValidation = false;
            }
        }else{
            $this->isValidation = false;
        }
    }

   private function  cleanClass()
   {
        $this->plugin = null;
        $this->pass = null;    
        $this->listPluginsControluser = array();            
        $this->user = false;
        $this->pluginPermissions = false;
        $this->pp_cols = false;
        $this->pp_adm = false;
        $this->isControleUser = false;            
        $this->pluginAllow = false;
   }
}
