<h1 id='titleSeeArticle'>   
    <?php 

    echo 'Sobre '.$dados['colunista']['apelido'] ;?>
</h1>
<p class='text-author'>
   <?php 
        echo $this->Avatar->getAuthorImage(
                    array(
                            'person_id'=>$dados['colunista']['person_id'], 
                            'image'=>$dados['avatar']['avatar'],
                            'idAvatar' => $dados['avatar']['id']
                        ));
            ?>  
                
                <?php echo $dados['colunista']['bio']; ?>
    
</p>
<br>