<?php
App::uses('CatArquivo', 'Arquivos.Model'); 
App::uses('UploadArquivo', 'Arquivos.Model'); 
class PaginateFolderFileComponent extends Component{
    private $list = false;
    private $id = null;
    private $page = 1;
    private $listFolders = array();
    private $listFiles = array();
    private $limitPage = 15;
    private $allItens = null;
    private $numberPages = null;
    
    public function generateList($id, $page){
        $this->cleanClass();
        $this->id = $id;
        $this->setPage($page);
        $this->setFolders();
        $this->setFiles();
        $this->mountList();
        $this->setList();
        return $this->list;
    }
    
    private function setList(){
      if(!empty($this->allItens)){
          $data = array_chunk($this->allItens, $this->limitPage);
          $this->numberPages = sizeof($data);
          $indice = $this->page - 1;
          $this->list = $data[$indice];
          
          
      }        
    }
    
    
    private function mountList()
    { 
        $this->allItens = array_merge($this->listFolders, $this->listFiles);
    }
    
    private function setFolders(){
       $CatArquivo = new CatArquivo();
       $CatArquivo->recursive = -1;
       $folderOptions = array(  'conditions'=>array('CatArquivo.isdeleted'=>'N', 'CatArquivo.parent_id'=>$this->id),
                                'order'=>array('CatArquivo.categoria'=>'asc')
                              );
       $find = $CatArquivo->find('all', $folderOptions);
      if(!empty($find))
      {    
          $i = 0;
          $totalSize = sizeof($find);
          while($i<$totalSize){
            $this->listFolders[$i]['id'] =   $find[$i]['CatArquivo']['id'];
            $this->listFolders[$i]['nome'] =   $find[$i]['CatArquivo']['categoria'];
            $this->listFolders[$i]['type'] =   'folder';
            $this->listFolders[$i]['descricao'] =   $find[$i]['CatArquivo']['descricao'];
            $this->listFolders[$i]['isprotected'] =   $find[$i]['CatArquivo']['isprotected'];
            $i++;
          }
      }
    }
    
    private function setFiles()
    {
       $UploadArquivo= new UploadArquivo();
       $UploadArquivo->recursive = -1;
       $fileOptions = array(
                            'conditions'=>array(
                                                'UploadArquivo.isdeleted'=>'N', 
                                                'UploadArquivo.catarquivo_id'=>$this->id),
                            'order'=>array('UploadArquivo.id'=>'DESC')
                            );
          $find = $UploadArquivo->find('all', $fileOptions);
          if(!empty($find))
          {
              $i = 0;
              $totalSize = sizeof($find);
              while($i<$totalSize){
                $this->listFiles[$i]['id'] =   $find[$i]['UploadArquivo']['id'];
                $this->listFiles[$i]['nome'] =   $find[$i]['UploadArquivo']['arquivo'];
                $this->listFiles[$i]['type'] =   'file';
                $this->listFiles[$i]['descricao'] =   $find[$i]['UploadArquivo']['descricao'];
                $i++;
              }
          }
    }

    public function getPage(){
        return $this->page;        
    }
    
    private function setPage($page){
        if(!empty($page['page'])){
            $this->page = $page['page'];
        }
    }
    
    public function getNumberPages(){
        return $this->numberPages;
        
        
    }
    
    
    private function cleanClass(){
        $this->list = false;
        $this->id = null;
        $this->page = 1;
        $this->listFolders = array();
        $this->listFiles = array();
        $this->allItens = null;
        $this->numberPages = null;
    }
}