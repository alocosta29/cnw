<h1>Resultados da pesquisa</h1>
 <?php 
 if(!empty($artigos)){
     $termo = $this->params['pass'][0];
     echo '<span style = "font-weight: bold; ">Termo pesquisado: <span style="color: #c02230; font-size:1.7em; ">'.$termo.'</span></span>';
     
    echo $this->Element('listArticles');
 }else{
     echo $errors;
 }
 ?>