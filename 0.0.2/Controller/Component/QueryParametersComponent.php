<?php
/**
 * Classe criada para retornar parâmetros de consulta do sistema.
 */
class QueryParametersComponent extends Component{
    
    /**
     * Método que retorna os parâmetros para lista dos produtos em promoção
     */
    public function getProdPromoParams($limit = 20)
    {
        $dateSelect = date('Y-m-d H:i:s');
        $options = array(
            'conditions' => array(
                                        'ProdutosPromocao.isdeleted' => 'N',
                                        'Produto.isdeleted'=>'N',
                                        'Promocao.isdeleted'=>'N',
                                        'Promocao.isactive'=>"Y",
                                        'Promocao.data_inicio <='=> $dateSelect,
                                        'Promocao.data_fim >='=> $dateSelect,
                                        'Produto.isdeleted'=>'N'                                  
                                  ),
            'order' => array('rand()'),
            'limit' => $limit
        ); 
        return $options;
    }
    
    
    
     /**
     * Método que retorna os parâmetros para lista dos produtos em promoção por categoria
     */
    public function getProdPromoCatParams($limit = 20, $categoria=null)
    {
        $dateSelect = date('Y-m-d H:i:s');
        $options = array(
            'conditions' => array(
                                        'Produto.isdeleted'=>'N',
                                        'Promocao.isdeleted'=>'N',
                                        'ProdutosPromocao.isdeleted' => 'N',
                                        'Promocao.isactive'=>"Y",
                                        'Promocao.data_inicio <='=> $dateSelect,
                                        'Promocao.data_fim >='=> $dateSelect,
                                        'Produto.isdeleted'=>'N'                                  
                                  ),
            'order' => array('Produto.nome' => 'ASC'),
    
            'limit' => $limit
        ); 
        if(!empty($categoria)){
            $options['conditions']['Produto.categoria_id'] = $categoria;
        }

        return $options;
    }
    
       
    /**
     * Método que retorna os parâmetros para consulta de profissionais 
     */
    public function getProfessionalsParams($data = null)
    {
       $options = array(
            'conditions' => array('Professional.isdeleted' => 'N'),
            'order' => array('Individual.nome' => 'ASC'),
            'limit' => 20
       );
       if(!empty($data['Professional']['profession_id']))
       {
            $options['conditions']['Professional.profession_id'] = $data['Professional']['profession_id']; 
       }      
       if(!empty($data['Professional']['nome']))
       {
                $termo = trim($data['Professional']['nome']);
                $replace_pairs =
                array
                (
                    'á' => 'a',
                    'é' => 'e',
                    'í' => 'i',
                    'ó' => 'o',
                    'ú' => 'u',
                    'à' => 'a',
                    'è' => 'e',
                    'ì' => 'i',
                    'ò' => 'o',
                    'ù' => 'u',
                    'ã' => 'a',
                    'õ' => 'o',
                    'â' => 'a',
                    'ê' => 'e',
                    'î' => 'i',
                    'ô' => 'o',
                    'ä' => 'a',
                    'ë' => 'e',
                    'ï' => 'i',
                    'ö' => 'o',
                    'ü' => 'u',
                    'ç' => 'c',
                    'Á' => 'A',
                    'É' => 'E',
                    'Í' => 'I',
                    'Ó' => 'O',
                    'Ú' => 'U',
                    'À' => 'A',
                    'È' => 'E',
                    'Ì' => 'I',
                    'Ò' => 'O',
                    'Ù' => 'U',
                    'Ã' => 'A',
                    'Õ' => 'O',
                    'Â' => 'A',
                    'Ê' => 'E',
                    'Î' => 'I',
                    'Ô' => 'O',
                    'Û' => 'U',
                    'Ä' => 'A',
                    'Ë' => 'E',
                    'Ï' => 'I',
                    'Ö' => 'O',
                    'Ü' => 'U',
                    'Ç' => 'C'
                );
                    $termo = strtr($termo, $replace_pairs);
                    $options['conditions']['Individual.nome LIKE '] = "%".$termo."%";
       }     
        return $options;       
    }
    
    
    
    /**
     * retorna os parâmetros de consulta de parâmetros
     */
  /* public function getLojasParams()
    {
         $options = array(
            'fields'=>array(
                            'Person.id', 'Loja.person_id', 'Loja.gerente', 
                            'Loja.tipo', 'Companie.fantasia','Contact.contato', 
                            'Contactstype.tipo'
                            
               
                            
                            ),
            'conditions'=>array(
                                'Loja.isdeleted'=>'N' ),
            'joins'=>array(
            
                          array(    'table' => 'persons',
                                    'alias' => 'Person',
                                    'type' => 'LEFT',
                                    'conditions' => array(
                                                'Loja.person_id = Person.id',
                                    )
                                ),
            
                            array(  'table' => 'companies',
                                    'alias' => 'Companie',
                                    'type' => 'LEFT',
                                    'conditions' => array(
                                                'Person.id = Companie.person_id',
                                    )
                                ),
            
                            array(  'table' => 'contacts',
                                    'alias' => 'Contact',
                                    'type' => 'INNER',
                                    'conditions' => array(
                                                'Loja.person_id = Contact.person_id',
                                    )
                                ),
            
            
                           ),
            'order'=>array('Companie.fantasia'=>'ASC')
                         );
        
        
        
        
        
        
        
        
        
        
        return $options;   
    }
        
    */
       
}