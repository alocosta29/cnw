<?php

        if(!empty($caderno)): 
            $arrayType = array(
                                'Articles' => 'ESCREVER: ',
                                'ManagerBook' => 'MODERAR: ',
                                'CreateAds' => 'CRIAR ANÚNCIOS: ',
                                'ManagerAds' => 'MODERAR ANÚNCIOS: '
                
                
                              );
            ?>
            <div style="
                   width: 100%; text-align: left; padding: 10px;
                  /* border-left: #1a1d1f 5px solid;*/
                   width: 90%;
                   float: left;
                  /* background-color:#dadada;*/
                   margin-left: 0px;
                   margin-bottom: 10px;
                   text-transform: uppercase;
                   font-size: 20px;
                   font-weight: bold;
                   ">::<?php echo $arrayType[$this->plugin].$this->ReturnData->getBook($caderno); ?>
            </div>
        <?php 
            endif;

?>