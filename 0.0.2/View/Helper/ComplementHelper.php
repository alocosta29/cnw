<?php 
App::uses('AppHelper', 'View/Helper'); 
class ComplementHelper extends AppHelper 
{
 public $helpers = array('Html', 'Time');
public function mask($val, $mask)
		{
			//Cria mascaras. Útil para cpf e outros documentos...fstatus
			//ex: $this->Complement->mask($dadosEmployee['cpf'],'###.###.###-##');
			$maskared = '';
			$k = 0;
			for($i = 0; $i<=strlen($mask)-1; $i++)
			{
				if($mask[$i] == '#')
				{
					if(isset($val[$k]))
					$maskared .= $val[$k++];
				} else {
					if(isset($mask[$i]))
					$maskared .= $mask[$i];
				}
			}
			return $maskared;
		}
 public function getMonth($mesNumeric)
    {
                switch ($mesNumeric) 
                {
                    case 1:
                        $mes = 'Janeiro';
                    break;
                    
                    case 2:
                        $mes = 'Fevereiro';
                    break;
                    
                    case 3:
                        $mes = 'Março';
                    break;
                     
                    case 4:
                        $mes = 'Abril';
                    break;
                     
                    case 5:
                        $mes = 'Maio';
                    break;
                    
                    case 6:
                        $mes = 'Junho';
                    break;
                     
                    case 7:
                        $mes = 'Julho';
                    break;
                     
                    case 8:
                        $mes = 'Agosto';
                    break;
                
                    case 9:
                        $mes = 'Setembro';
                    break;
                
                    case 10:
                        $mes = 'Outubro';
                    break;

                    case 11:
                        $mes = 'Novembro';
                    break;

                    case 12:
                        $mes = 'Dezembro';
                    break;
                }
                return $mes;
    }
 
 
 /**
  * Método que traduz as flags Y/N
  */
  public function getResponse($flag){
      if($flag == 'Y'){
          return 'Sim';
          
      }else{
          return 'Não';
      }
      
      
  }
     public function cryptDecrypt($termo, $crypt = false)
    {
              $retorno = "";
              $chave = "vt2014development29051981";
    
              if($crypt)
              {
                    $string = $termo;
                    $i = strlen($string)-1;
                    $j = strlen($chave);
                    do
                    {
                      $retorno .= ($string{$i} ^ $chave{$i % $j});
                    }while ($i--);
                
                    $retorno = strrev($retorno);
                    $retorno = base64_encode($retorno);
              }else{
                    $string = base64_decode($termo);
                    $i = strlen($string)-1;
                    $j = strlen($chave);
                    do
                    {
                      $retorno .= ($string{$i} ^ $chave{$i % $j});
                    }while ($i--);
                
                    $retorno = strrev($retorno);
              }
              return $retorno;
    }
 
     public function crypt($string, $key, $crypt = false)
            {
              $retorno = "";
              if(!empty($string))
              {
                  if($crypt)
                    {
                      $string = $string;
                      $i = strlen($string)-1;
                      $j = strlen($key);
                       do
                      {
                        $retorno .= ($string{$i} ^ $key{$i % $j});
                      }while ($i--);

                      $retorno = strrev($retorno);
                      $retorno = base64_encode($retorno);
                    }
                    else
                    {
                      $string = base64_decode($string);
                      $i = strlen($string)-1;
                      $j = strlen($key);
                      do
                      {
                        $retorno .= ($string{$i} ^ $key{$i % $j});
                      }while ($i--);
                        $retorno = strrev($retorno);
                    }
              } 
              return $retorno;
            }
    
    
 /**
  * Método que traduz as flags Y/N
  */
  public function getStatus($status){
      if($status == 1){
          return 'Ativo';
      }else{
          return 'Inativo';
      }
  }
  
  
  /**
  * Método que traduz as flags Y/N
  */
  public function getStatusActive($status){
      if($status == 'Y'){
          return '<span style = "color: #008000; font-weight: bold; ">ATIVO</span>';
      }else{
          return '<span style = "color: #FF0000; font-weight: bold; ">INATIVO</span>';
      }
  }
  
  /**
  * Método que traduz as flags Y/N
  */
  public function getStatusYesNo($status){
      if($status == 'Y'){
          return '<span style = "color: #008000; font-weight: bold; ">SIM</span>';
      }else{
          return '<span style = "color: #FF0000; font-weight: bold; ">NÃO</span>';
      }
  }
  
  
  public function getStatusPost($status = false)
  {
      switch ($status) {
         case 'R':
            return "<span style = 'color: #FF4500; font-weight: bold; '>RASCUNHO</span>";   
         break;
      
         case 'P':
            return "<span style = 'color: #006400; font-weight: bold; '>PROGRAMADO/PUBLICADO</span>";   
         break;
      
         case 'N':
            return "<span style = 'color: #FF0000; font-weight: bold; '>NECESSITA REVISÃO</span>";   
         break;

         case 'A':
            return "<span style = 'color: #4682B4; font-weight: bold; '>EM ANÁLISE</span>";   
         break;
      
         default:
              return $status;
         break;
      }
  }
  
    public function getSex($data)
    {
        $sexData = array('M' => 'Masculino', 'F' => 'Feminino');    
        if(!empty($sexData[$data])){
            return $sexData[$data];
        }else{
            return false;
        }  
    } 
  
    
    public function getSimpleName($name = null){
        
        $return = false;
        if(!empty($name)){
            $name = explode(' ', $name);
            $nameRet= $name[0];
            if(!empty($name[1])){
                $nameRet .= ' '.$name[1];
            }
            $return = $nameRet;
        }
        return $return;
        
    }
    
    
    public function linkCol($name = null, $alias = null, $class="nameCol"){
        $return = false;
        if(!empty($name) and !empty($alias)){
            $name = explode(' ', $name);
            $nameCol = $name[0];
            if(!empty($nameCol[1])){
                $nameCol .= ' '.$name[1];
            }
            $return = $this->Html->link($nameCol, array('plugin'=>false, 'controller'=> false, 'action'=>'colunista', $alias), array('class'=>$class, 'target'=>'_blank'));
        }
        return $return;
    }
    
    /**
     * Busca os dados do colunista na base de dados
     * @param type $params
     * @param type $class
     * @return type
     */
    public function linkColSearch($params, $class="nameCol"){
       $return = false;
       if(!empty($params['name']) and !empty($params['alias'])){
           $return = $this->linkCol($params['name'], $params['alias'], $class);
       }elseif(!empty($params['person_id']))
       {
           $Colunista = ClassRegistry::init('ManagerBook.Colunista');
           $Colunista->recursive = -1;
           $find = $Colunista->findByPerson_id($params['person_id']);
           if(!empty($find['Colunista'])){
                
               $return = $this->linkCol($find['Colunista']['apelido'], $find['Colunista']['alias'], $class);
           }
       } 
       return $return;
    }
    
    
    
    
    /**
     * Retorna data formatada
     */
    public function getDateArticle($dateS = null){
        $return = null;
        if(!empty($dateS)){
            $return = date('d', strtotime($dateS));
            $return .= ' '.$this->getMonth(date('m', strtotime($dateS))).' ';
            $return .= date('Y', strtotime($dateS));
        }
        return $return;
    }
  
    
    public function getAvatar($person_id, $image, $type = 'normal')
    {
        if($type == 'normal'){
            $url = HOST_IMAGE.'avatars'.DS.$person_id.DS;
        }else{
            $url = HOST_IMAGE.'avatars'.DS.$person_id.DS.'thumb'.DS;
        }
        $checkImage = $url.$image;
    }
    
    /**
           * Retorna a url da imagem destaque do artigo
           * @param type $params
           * @return string
           */
    public function getUrlImage($params = array('folder'=>null, 'img'=>null))
    {
            $image = HOST_IMAGE.'noImg.png';
            if(!empty($params['img']) and !empty($params['folder']))
            {
                $checkImg = WWW_ROOT.'img'.DS.'img_destak'.DS.$params['folder'].DS.$params['img'];          
                if(file_exists($checkImg)){
                    $image = HOST_IMAGE.'img_destak/'.$params['folder'].'/'.$params['img'];
                }
            }
            return $image;
    }
    
    
    
     /**
           * Retorna a url da imagem simbolo do arquivo extra do artigo
           * @param type $params
           * @return string
           */
    public function getUrlImageExtra($params = array('img'=>null))
    {
            $image = HOST_IMAGE.'extra_icons/nidentificado.png';
            if(!empty($params['img']))
            {
                $checkImg = WWW_ROOT.'img'.DS.'extra_icons'.DS.$params['img'];          
                if(file_exists($checkImg)){
                    $image = HOST_IMAGE.'extra_icons/'.$params['img'];
                }
            }
            return $image;
    }
    
    
    
    
public function limitarTexto($texto, $limite, $quebrar = true){
  $atual = $texto; 
  $contador = strlen($texto);
  if ( $contador >= $limite ) {      
      $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) ;
      if(!empty($texto)){
         $texto = $texto. '...';
      }else{
          $texto = $atual;
      }
      return $texto;
  }
  else{
    return $texto;
  }
 

}

public function getIconExtra($alias = null){
    $img = 'nidentificado.png';
    if(!empty($alias)){
        $arrayImg = array(
            'png' => 'image.png',
            'jpg' => 'image.png',
            'gif' => 'image.png',
            'doc' => 'word.png',
            'docx' => 'word.png',
            'ppx' => 'ppoint.png',
            'ppt' => 'ppoint.png',
            'xls' => 'excel.png',
            'xlsx' => 'excel.png',
            'pdf' => 'pdf.png',
            'ppsx'=>'ppoint.png'
            
        );
        if(!empty($arrayImg[$alias])){
            $img = $arrayImg[$alias];
        }
        return $img;
    }
}

 public function getStatusAd($status = false)
  {
      switch ($status) {
         case 'R':
            return "<span style = 'color: #FF4500; font-weight: bold; '>RASCUNHO</span>";   
         break;
      
         case 'P':
            return "<span style = 'color: #006400; font-weight: bold; '>PROGRAMADO/PUBLICADO</span>";   
         break;
      
         case 'N':
            return "<span style = 'color: #FF0000; font-weight: bold; '>NECESSITA REVISÃO</span>";   
         break;

         case 'A':
            return "<span style = 'color: #4682B4; font-weight: bold; '>EM ANÁLISE</span>";   
         break;
      
     
     case 'O':
            return "PUBLICAÇÃO OCULTA";   
         break;
     
         default:
              return $status;
         break;
      }
  }



}