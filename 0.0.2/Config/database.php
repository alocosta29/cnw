<?php
$host = $_SERVER['HTTP_HOST'];
if(($host == 'desenvolvimento') )
{
    class DATABASE_CONFIG {       
            public $default = array(
                    'datasource' => 'Database/Mysql',
                    'persistent' => false,
                    'host' => 'localhost',
                    'login' => 'root',
                    'password' => '11',
                    //'database' => 'base_sistemas',
                    'database' => 'andre_questions',
                    'encoding' => 'utf8'
            );
        }
}elseif(in_array($host , array('www.crescernaweb.com.br', 'www.crescernaweb.com', 'crescernaweb.com', 'crescernaweb.com.br')))
{ 
     class DATABASE_CONFIG {
            /*public $default = array(
                    'datasource' => 'Database/Mysql',
                    'persistent' => false,
                    'host' => 'mysql1.crescernaweb.com.br',
                    'login' => 'crescernaweb1',
                    'password' => 'andcam1929',
                    'database' => 'crescernaweb1',
                    'encoding' => 'utf8'
            );*/
         
         
                   public $default = array(
                    'datasource' => 'Database/Mysql',
                    'persistent' => false,
                    'host' => 'localhost',
                    'login' => 'cresc230_cnw',
                    'password' => 'cnw012017',
                    'database' => 'cresc230_cnw',
                    'encoding' => 'utf8'
            );
         
         
        }
}elseif($host == 'debian8')
{ 
     class DATABASE_CONFIG {
            public $default = array(
                    'datasource' => 'Database/Mysql',
                    'persistent' => false,
                    'host' => 'debian8',
                    'login' => 'root',
                    'password' => '11',
                    'database' => 'cnw',
                    'encoding' => 'utf8'
            );
        }
}elseif($host == 'localhost')
{ 
            $so = strpos($_SERVER['SCRIPT_FILENAME'], 'LABORATORIOS');
            if($so === false)
            {
                    class DATABASE_CONFIG {
                        public $default = array(
                                'datasource' => 'Database/Mysql',
                                'persistent' => false,
                                'host' => 'localhost',
                                'login' => 'root',
                                'password' => '',
                                'database' => 'cnw',
                                'encoding' => 'utf8'
                        );
                }
            }else{
                class DATABASE_CONFIG {
                        public $default = array(
                                'datasource' => 'Database/Mysql',
                                'persistent' => false,
                                'host' => 'localhost',
                                'login' => 'root',
                                'password' => '11',
                                'database' => 'cnw',
                                'encoding' => 'utf8'
                        );
                       
                }   
            }
}else{
  $so = $_SERVER['SSL_SERVER_S_DN'];
            if($so == 'CN=lubuntu')
            {
                class DATABASE_CONFIG {
                        public $default = array(
                                'datasource' => 'Database/Mysql',
                                'persistent' => false,
                                'host' => 'localhost',
                                'login' => 'root',
                                'password' => '11',
                                'database' => 'labs',
                                'encoding' => 'utf8'
                        );
                }   
            }else{
                class DATABASE_CONFIG {
                        public $default = array(
                                'datasource' => 'Database/Mysql',
                                'persistent' => false,
                                'host' => 'localhost',
                                'login' => 'root',
                                'password' => '',
                                'database' => 'cnw',
                                'encoding' => 'utf8'
                        );
                }
            }
}


