<br>
<ul>
        <?php 
                if($this->params['controller'] == "articles")
                {
                    if($this->action <> 'admin_index'):
                        echo '<li>'.$this->Html->link('Página inicial', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'index', $caderno)).'<li>';
                    endif; 

                    if($this->action <> 'admin_add'):
                        echo '<li>'.$this->Html->link('Criar artigo', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'add', $caderno)).'<li>'; 
                    endif; 

                    if($this->action <> 'admin_listPosts'):
                        echo '<li>'.$this->Html->link('Listar artigos', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'listPosts', $caderno)).'<li>';   
                    endif; 

                     if($this->action <> 'admin_publishPosts'):
                        echo '<li>'.$this->Html->link('Artigos publicados', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'publishPosts', $caderno)).'<li>';   
                    endif; 
                }else{
                    echo '<li>'.$this->Html->link('Página inicial', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'index', $caderno)).'<li>';
                    echo '<li>'.$this->Html->link('Criar artigo', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'add', $caderno)).'<li>'; 
           
                    echo '<li>'.$this->Html->link('Listar artigos', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'listPosts', $caderno)).'<li>';   
                    echo '<li>'.$this->Html->link('Artigos publicados', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'publishPosts', $caderno)).'<li>';  
                }
        ?>
    <br>
        <?php 
            if(!isset($idArtigo)):  $idArtigo = false; endif; 
            
            if($this->action <> 'admin_view' and $ValidEdit->start($idArtigo, 'view_col')):
                echo '<li>'.$this->Html->link('Visualizar artigo', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'view', $caderno, $idArtigo)).'</li>'; 
            endif;
            
            if($this->action <> 'admin_editPublicationDate' and $ValidEdit->start($idArtigo, 'editDate')):
                    echo '<li>'.$this->Html->link('Editar data de publicação', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'editPublicationDate', $caderno, $idArtigo)).'</li>'; 
            endif;
            
            if($this->action <> 'admin_edit' and $ValidEdit->start($idArtigo, 'edit')):
                echo '<li>'.$this->Html->link('Editar artigo', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'edit', $caderno, $idArtigo)).'</li>'; 
            endif;
            
            if($this->action <> 'admin_editResumo' and $ValidEdit->start($idArtigo, 'summary')):
                echo '<li>'.$this->Html->link('Editar resumo', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'editResumo', $caderno, $idArtigo)).'</li>'; 
            endif;

            if($this->action <> 'admin_featuredImage' and $ValidEdit->start($idArtigo, 'featuredImage')):
                echo '<li>'.$this->Html->link('Imagem destacada', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'featuredImage', $caderno, $idArtigo)).'</li>'; 
            endif;

            if($this->action <> 'admin_editKeyWords' and $ValidEdit->start($idArtigo, 'editKeyWords')):
                echo '<li>'.$this->Html->link('Palavras-chave', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'editKeyWords', $caderno, $idArtigo)).'</li>'; 
            endif;
            
            if($ValidEdit->start($idArtigo, 'send_analysis', 'A')):
                echo '<li>'.$this->Form->postLink(__('Enviar para análise'), array('action' => 'changeStatus', $caderno, $idArtigo, 'A'), null, __(''
                                    . 'Após o envio do artigo para análise, o mesmo não poderá ser editado e será enviado para aprovação do moderador.'
                                    . 'Tem certeza que deseja fechar o artigo?', null)).'<li>';
            endif;

            if($ValidEdit->start($idArtigo, 'return_draft', 'R')):
                echo '<li>'.$this->Form->postLink(__('Retornar para o status rascunho'), array('action' => 'changeStatus', $caderno, $idArtigo, 'R'), null, __(''
                            . 'Após o retorno do status para rascunho será necessário enviá-lo novamente para a aprovação do moderador.'
                            . 'Tem certeza que deseja continuar esta operação?', null)).'<li>';
            endif;
            
         if($this->action <> 'admin_add_extra' and $ValidEdit->start($idArtigo, 'addExtra')):
                echo '<li>'.$this->Html->link('Anexar arquivo', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'addExtra', $caderno, $idArtigo)).'</li>'; 
            endif;
            
            

            if($idArtigo):
                echo '<li>'.$this->Html->link('Preview', array('plugin'=>'articles', 'controller'=>'articles', 'action'=>'previewPost', $caderno, $idArtigo), array('target'=>'_blank')).'</li>'; 
            endif;
        ?>    
    
</ul>
