<?php
switch ($variavel['Artigo']['status']) {
    case 'R':
echo $this->Form->postLink(__('Fechar artigo'), array('action' => 'changeStatus', 
          $caderno, $dataArticle['id'], 'P'), null, __(''
                  . 'Após o fechamento do artigo, o mesmo não poderá ser editado e será enviado para aprovação do moderador.'
                  . 'Tem certeza que deseja fechar o artigo %s?', $dataArticle['titulo'])); 

        break;

    default:
        break;
}



?>