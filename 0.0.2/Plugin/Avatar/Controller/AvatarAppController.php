<?php
App::uses('AppController', 'Controller');
class AvatarAppController extends AppController 
{
        public function _uploadFile($arquivo, $pasta, $name)
        {        
            try{
                    $filenameX = $arquivo['name'];
                    $extension = explode('.', $arquivo['name']);
                    $extensao = '.'.$extension[1];
                    $name = $name.$extensao;
                    $tmpUpload =  $arquivo['tmp_name'];
                    //$dirTemp = WWW_ROOT.'img'.DS.'images'.DS; //Esse é o diretório onde ficará os arquivos enviados, lembre-se de criá-lo. Este script não cria diretórios
                    $dirTemp = $pasta;
                    $filename = $dirTemp.$filenameX;
                    $chkdeltb= '';
                    if(isset($_POST["chkdeltb"])) $chkdeltb = $_POST["chkdeltb"];
                    if(!file_exists($dirTemp)) mkdir($dirTemp); #Cria diretorio temporario, caso nao exista.
                    if(is_uploaded_file($tmpUpload)){
                        //Testa se o upload foi bem sucedido
                        move_uploaded_file($tmpUpload,$filename); // Faz o upload para a pasta gerre_temp
                        rename($dirTemp.$filenameX, $dirTemp.$name);
                    }
                    $file = $filename;	
                    $return = true;
                }catch(Exception $e){
                    $return = false;
                }
                return $return;
        }
}
