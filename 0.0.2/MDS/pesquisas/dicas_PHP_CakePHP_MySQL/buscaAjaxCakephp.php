<?php
/**
Variações da consulta em ajax, utilizando os padrões do cakephp-2x

FONTES:
http://www.riabox.com.br/blog/efetuando-requisicao-ajax-com-cakephp/
http://www.devdungeon.com/content/ajax-form-submit-cakephp-2x

Precisei fazer uma consulta no cakephp utilizando o ajax e obedecendo aos padrões estabelecidos pelo framework. A solução adotada foi a seguinte:
Criei duas "views"
View admin_index.ctp
Nesta view coloquei o formulário de consulta

**/
?>
<?php #código jquery - máscara ?> 
<?php echo $this->Html->script(array('Layout.sgpLayout/jquery.mask')); ?>
<h2>Pontos diários lançados</h2>
 <?php 
 echo $this->Form->create('BankHour', array('class' => 'default2', 'id'=>'form1'));  
 echo $this->Form->input('dtinicio', array('label'=>'De:', 'id'=>'dt'));
 echo $this->Form->input('dtfim', array('label'=>'Até', 'id'=>'dt1'));
 ?>
 
<?php #código jquery para a máscara ?> 
<script>
	jQuery(function($)
	{
		$("#dt").mask("99/99/9999");
		$("#dt1").mask("99/99/9999");
	});
</script> 
 
 <?php 
        /**
		botão submit. a variável "update" indica em qual div será "cuspida" o conteúdo da consulta. a variavel "action" indica qual
		método será responsável pela consulta
		*/
       echo $this->Js->submit('Consultar', array('update' => '#response', 'url' => array('action' => 'listPoint', 'foo', 'bar')));
       
	   #chamo a biblioteca jquery atualizada
	   echo $this->Html->script('jquery');
	   
	   #verificar o motivo desta linha
       echo $this->Js->writeBuffer(array('inline' => 'true'));
      
	  
	  //a variavel $data receberá o conteudo digitado nos campos do formulario
      $data = $this->Js->get('#form1')->serializeForm(array('isForm' => true, 'inline' => true));
	  
	  /**
	  *aqui eu informo que uma mudança no conteudo do campo de id "#dt" deverá acionar o submitcom os parametros  especificados abaixo
	  Dentre eles, a variável data, atualizada, com o conteudo alterado no formulario
	  */
      $this->Js->get('#dt')->event(
                'change', 
                $this->Js->request(
                        array('action' => 'listPoint', $data), 
                        array(
                            'async' => true, 
                            'update' => '#response',
                            'data' => $data,
                            'dataExpression'=>true,
                            'method' => 'POST'
                            )));

//assim como o campo anterior, aqui eu informo que uma mudança no conteudo do campo de id "#dt1" deverá acionar o submit com os parametros  especificados abaixo
    $this->Js->get('#dt1')->event(
            'change', 
            $this->Js->request(
                    array('action' => 'listPoint', $data), 
                    array(
                        'async' => true, 
                        'update' => '#response',
                        'data' => $data,
                        'dataExpression'=>true,
                        'method' => 'POST'
                        )));

		#aqui eu deixo a div que terá o conteudo da consulta						 
		 echo "<div id='response'></div>";
		 
		 #fim da View admin_index.ctp
		 ###############################################################################################3
		 
	?>
<?php 

#Conteudo do controlle Controller

//nesse helper eu chamo a biblioteca jquery
public $helpers = array('Js' => array('Jquery')); 


//esse método eh uma adaptação para eliminar a necessidade de configurar as permissões para a view que cuspirá o resultado da consulta
public function beforeFilter()
{
	parent::beforeFilter();
	$this->Auth->allow('admin_listPoint');
}
    		
/**
 * Exemplo de método que retorna o resultado da busca
 Esse método "cospe" o resultado da consulta. o conteudo dele deverá sair na div "response" criada na view admin_index. Você poderá "cuspir" o conteudo dele direto no método sem a utilização e criação de um arquivo .ctp ou poderá fazer a criação do arquivo .ctp. 
 lembre-se sempre de inserir a linha que desativa o layout('$this->layout = false')

 */
public function admin_listPoint(){

	$this->layout = false;
// parâmetros da requisição
	pr($this->request->data); exit(0);
	$this->set('teste', 'teste');
	
}	
	
/**
*Exemplo de método que conterá o formulario. Personalize da forma que quiser
*/
public function admin_index(){ }
	
 #fim do controller exemplo.
 /**
OBS.: A view que poderá ser criada para o retorno do resultado de consulta poderá ser personalizada da forma que desejar.
 */
 ###############################################################################################3















?> 


