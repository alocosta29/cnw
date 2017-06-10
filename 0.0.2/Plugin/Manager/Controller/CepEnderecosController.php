<?php
App::uses('ManagerAppController', 'Manager.Controller');
class CepEnderecosController extends AppController 
{
	public $uses = array('Manager.CepEndereco', 'Manager.CepCidade', 'Manager.CepBairro', 'Manager.CepEstado');


public function beforeFilter()
	{
		
		parent::beforeFilter();
		$this->Auth->allow('ajaxMsg');
	}

	public function ajaxMsg()
	{
		$this->layout = "";
		$cep = $this->params['url']['cep'];
		$teste = $this->CepEndereco->find('all', array(
					'conditions'=>array(
					'CepEndereco.cep'=>$cep),
					'fields'=>array('CepEndereco.uf', 'CepEndereco.nomeslog', 'CepEndereco.logradouro', 
					'CepEndereco.cep', 'CepCidade.nome', 'CepBairro.nome')));
		//$teste2 = 	$this->CepEndereco->find('all', array('limit'=> 1));			
		$resultado['uf'] = $teste[0]['CepEndereco']['uf'];
		$resultado['cidade'] = $teste[0]['CepCidade']['nome'];
		$resultado['logradouro'] = $teste[0]['CepEndereco']['logradouro'];
		$resultado['nomeslog'] = $teste[0]['CepEndereco']['nomeslog'];
		$resultado['bairro'] = $teste[0]['CepBairro']['nome'];

		$teste = json_encode($resultado);
		$this->set("mensagem", $teste);
	}
}
