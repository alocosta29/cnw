<?php
        $color = "#fff";
        $textColor = "#000";
        $text = 'INDEFINIDO';
        $listColors = array(
            'P' => array(
                'textColor' => '#fff',
                'color' =>'#006400',
                'text' => 'PROGRAMADO/PUBLICADO'
            ),
            'R' => array(
                'textColor' => '#fff',
                'color' =>'#FF8C00',
                'text' => 'MODO RASCUNHO'
            ),
            'A' => array(
                'textColor' => '#fff',
                'color' =>'#4682B4',
                'text' => 'EM ANÁLISE'
            ),
            'N' => array(
                'textColor' => '#fff',
                'color' =>'#FF0000',
                'text' => 'ENVIADO PARA REVISÃO'
            ),
        );
        if(!empty($listColors[$dataAd['status']])){
            $color = $listColors[$dataAd['status']]['color'];
            $textColor = $listColors[$dataAd['status']]['textColor'];
            $text = $listColors[$dataAd['status']]['text'];
        }
?>
<table cellpadding="5px" class="scrollQuebra">
        <tr>
            <td colspan="2" style="background-color: <?php echo $color; ?>; color: <?php echo $textColor; ?>; text-align: left; font-weight: bold; "><?php echo $text; ?></td>
        </tr>
        
        <tr>
          <td><?php  echo $this->Html->image('img_ads/'.$dataAd['user_id'].'/'.$dataAd['imagem'], array('style'=>'max-width: 200px; ')); ?> </td>
          <td style="line-height: 30px; " valign="top"><?php
        echo '<strong>TIPO: </strong>'.$dataAd['tipo'].'<br>';
        echo '<strong>VERSÃO: </strong>'.$dataAd['versao'].'<br>';
        echo '<strong>LINK: </strong><a href = '.$dataAd['link'].' target="_blank">'.$dataAd['link'].'</a><br>';
        ?>
    </td>
     </tr>
     <tr>
         <td><strong>DATA/HORA DE INICIO DE VEICULAÇÃO: </strong></td>
         <td><?php echo $this->Time->format('d/m/Y H:i', $dataAd['data_inicio']); ?></td>
     </tr>
     
     <tr>
         <td><strong>DATA/HORA FINAL DE VEICULAÇÃO: </strong></td>
         <td><?php echo $this->Time->format('d/m/Y H:i', $dataAd['data_fim']); ?></td>
     </tr>
     <tr>
         <td><strong>AUTOR: </strong></td>
         <td><?php echo $dataAd['criado_por']; ?></td>
     </tr>
      <tr><td colspan="2"><strong>REVISÕES</strong></td></tr>
     <tr><td colspan="2"><?php 
     if(!empty($dataAd['comments'])){
       echo $dataAd['comments'];  
     }else{
         echo "<span class='text-destak'>NÃO HÁ REVISÕES</span>";
     }
      ?> </td></tr>
    </table>
