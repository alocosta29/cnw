<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class PermissionsController extends ManagerAppController {
/**
 * Método que consulta usuários e permissões
 */
public function admin_index(){}

public function admin_add($id=null){}




public function admin_delete($id=null){}






public function admin_ativaModel($id = null)
	{
			$this->Model->id = $id;
			if(!$this->Model->exists()) 
			{
				throw new NotFoundException(__($this->Mensagens->registroInvalido));
			}				
			$ModelParaAtivar['Model']['isactive']='Y';
			$ModelParaAtivar['Model']['id'] = $id;
			if($this->Model->saveAll($ModelParaAtivar))
			{
				$this->Session->setFlash(__('Model ativado com sucesso!!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index', 'admin'=>TRUE));
			}
			$this->Session->setFlash(__('O model nÃ£o pode ser ativado. Por favor tente novamente'), 'default', array());
			$this->redirect(array('action' => 'index', 'admin'=>TRUE));
	}

	public function admin_desativaModel($id = null)
	{
			$this->Model->id = $id;
			if (!$this->Model->exists()) 
			{
				throw new NotFoundException(__($this->Mensagens->registroInvalido));
			}				
			$ModelParaDesativar['Model']['isactive']='N';
			$ModelParaDesativar['Model']['id'] = $id;
			if($this->Model->saveAll($ModelParaDesativar))
			{
				$this->Session->setFlash(__('Model desativado com sucesso!!'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index', 'admin'=>TRUE));
			}
			$this->Session->setFlash(__('O model nÃ£o pode ser desativado. Por favor tente novamente'), 'default', array());
			$this->redirect(array('action' => 'index', 'admin'=>TRUE));
	}
        
        
}