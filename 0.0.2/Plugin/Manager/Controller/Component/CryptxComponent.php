<?php
class CryptxComponent extends Component {
	private $prefixo = 'l1I'; #Engessado em sempre tres caracters no inicio da criptografia de retorno, identificando assim o resultado como ok.
	private $chave = "*-asdf5f/��4-@%6�=+-;!z+"; 
	
	/* encrypt criptografa e/ou descriptografa uma string qualquer, fornecida no parametro "frase" com uma chave qualquer executando um 
	    XOR entre cada caractere, invertendo a sequencia e codificando em hexadecimal.
	    Se $crypt = true, a fun��o criptografa a frase fornecida. Caso false ela a descriptografa.
	    Exemplo de uso:
	    $chave = "q6w43a2sc1d6e98r6d5f6dasdfa313d525a35dsf";//Chave a ser utilizada na criptografia/descriptografia
	   $frase = "Teste de encripta��o de frases!!!";
	   $crypt = encrypt($frase, true);
	   $decrypt = encrypt($crypt, false);
	   echo "Frase = ".$frase."<br>";
	   echo "Cript = ".$crypt."<br>";
	   echo "Decript = ".$decrypt."<br>";
	*/
	public function encrypt($frase, $crypt=true) {
		
	  	$retorno = "";
	
	  	if ($frase=='') return '';
	  	if ( (substr($frase, 0, strlen($this->getPrefixo())) !== $this->getPrefixo()) && $crypt===false ) return '';
	  	
	  	if ( $crypt ) {
	    	$string = $frase;
	    	$i = strlen($string)-1;
	    	$j = strlen($this->chave);
	     	do {
	      		$retorno .= ($string{$i} ^ $this->chave{$i % $j});
	    	} while ( $i-- );
	
	    	$retorno = strrev($retorno);
	    	$retorno = base64_encode($retorno);
	  	} else {
	  		$frase = substr($frase, strlen($this->getPrefixo()), (strlen($frase)-strlen($this->getPrefixo())) );
	    	$string = base64_decode($frase);
	    	$i = strlen($string)-1;
	    	$j = strlen($this->chave);
		    do {
	      		$retorno .= ($string{$i} ^ $this->chave{$i % $j});
	    	} while ( $i-- );
	
	    	$retorno = strrev($retorno);
	  	}
	  	return $this->getPrefixo().$retorno;
	}


	public function getPrefixo()
	{
	    return $this->prefixo;
	}
}
