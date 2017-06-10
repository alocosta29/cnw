 <?php
 #PHP - Somar ou Subtrair dias de uma data - Add or Subtract days from a date
#Adicionar
#10 dias a partir de hoje
echo date('d/m/Y', strtotime("+10 days"));

# 10 dias a partir de uma data
echo date('d/m/Y', strtotime("+10 days",strtotime('20-07-2011')));

#Subtrair
# 10 dias a partir de hoje
echo date('d/m/Y', strtotime("-10 days"));

# 10 dias a partir de uma data
echo date('d/m/Y', strtotime("-10 days",strtotime('20-07-2011'))); 


 //acertar a hora do apache
 date_default_timezone_set('America/Sao_Paulo');
 //nao exibir erro de formatação de caracteres nas palavras
 echo '<meta http-equiv="Content-Type"  content="text/html; charset=UTF-8">'; 
 $inicio = '07-05-2014 13:10:00';
 $fim    = '08-05-2014 13:20:00'; 
 
 // Converte as duas datas para um objeto DateTime do PHP
 // PARA O PHP 5.3 OU SUPERIOR
 $inicio = DateTime::createFromFormat('d-m-Y H:i:s', $inicio); 
 
 // PARA O PHP 5.2// 
 $inicio = date_create_from_format('d/m/Y H:i:s', $inicio); 

 $fim = DateTime::createFromFormat('d-m-Y H:i:s', $fim);// 
 $fim = date_create_from_format('d/m/Y H:i:s', $fim);
 $diff = $inicio->diff($fim);
 var_dump($diff); 
 //Mostra todo o array       
 $resultado  = "A diferença entre as datas é de ";        
 $resultado .= "{$diff->format('%d Dias')} ";        
 $resultado .= "{$diff->format('%m Meses')} ";        
 $resultado .= "{$diff->format('%y Anos')} ";        
 $resultado .= "{$diff->format('%h Horas')} ";        
 $resultado .= "{$diff->format('%i Minutos')} ";       
 $resultado .= "{$diff->format('%s Segundos')}.";
 echo $resultado;?>