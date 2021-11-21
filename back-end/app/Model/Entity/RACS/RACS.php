<?php

namespace App\Model\Entity\RACS;

use \SandroAmancio\DatabaseManager\Database;

use App\Traits\TraitGetIp;




//RESPONSÁVEL POR UMA INSTÂNCIA DE 
class RACS{

    /**
     * 1)
     * ID do colaborador
     *
     * @var integer
     */
    public $idRoot;
    /**
     * 2)
     * Nome de usuário
     *
     * @var string
     */
    public $name;
    /**
     * 3)
     * Apelido
     *
     * @var string
     */
    public $nickName;
    /**
     * 4)
     * Email do usuário
     *
     * @var string
     */
    public $email;
    /**
     * 5)
     * Senha do usuário
     *
     * @var string
     */
    public $password;
    /**
      * 6)
     * Data de criação
     *
     * @var date
     */
    public $createDate;
    /**
      * 7)
     * Define o tipo de permisão do cliénte
     *
     * @var string
     */
    public $permission;
    /**
      * 8)
     * Define um toque para validar o cadastro
     *
     * @var string
     */
    public $token;
    /**
     * 9)
     * IP de sessão do usuário
     *
     * @var string
     */
    private $trait;

    /**
     * 10)
     * data da atual
     *
     * @var string
     */
    private $dateNow;
    

    public function __construct()
    {
        $this->trait = TraitGetIp::getUserIp();
        $this->dateNow = date("Y-m-d H:i:s");
    }
    /**
     * Método responsável por inserir uma tentativa de login de usuário
     *
     * @return void
     */
    public function insertAttempt(){


        if($this->countAttempt() < 5){
           
            $this->id = (new Database('attempt'))->insert([
                'ip'       => $this->trait, 
                'date'  => $this->dateNow,
            ]);
        }
    }

    /**
     * Metódo responsável por conta as tentativas de login
     *
     * @return integer
     */
    public function countAttempt()
    {

        $b = (new Database('attempt'))->select('ip = "'.$this->trait.'"');
    
        $r=0;
        while($f=$b->fetch(\PDO::FETCH_ASSOC)){
            if(strtotime($f["date"]) > strtotime($this->dateNow)-1200){
                $r++;
            }
        }
        return $r;
    }
    /**
     * Metódo responsável por deleta as tentativas
     *
     * @return void
     */
    public function deleteAttempt()
    {
        return (new Database('attempt'))->delete('ip = "'.$this->trait.'"');
        
    }
    /**
     * Metódo responsável por retornar o token pelo email
     *
     * @param [type] $email
     * @return object
     */
    public static function getRACSToken($email){

        return (new Database('confirmation'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }
    /**
     * Metódo responsável por inserir um novo usuário
     *
     * @return void
     */
    public function insertNewRACS(){
        
       
        //Inserio os dados do usuario no banco de dados
        $this->idRoot = (new Database('racs'))->insert([
            
            'name'         => $this->name,  
            'nickName'     => $this->nickName,  
            'email'        => $this->email,
            'password'     => $this->password,
            'createDate'   => $this->createDate,  
            'permission'   => $this->permission,  
            'status'       => $this->status,  
               
        ]);

        $this->id = (new Database('confirmation'))->insert([
            
            'email'  => $this->email,
            'token'  => $this->token,
           
        ]);
        //Sucesso
        return true;

    }
    /**
     * Método reponsável por atualizar o usuário
     *
     * @return void
     */
    public function updateRACS(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('racs'))->update('idRoot = '.$this->idRoot,[

            'name'         => $this->name, 
            'nickName'     => $this->nickName, 
            'email'        => $this->email,
            'password'     => $this->password,  
            'permission'   => $this->permission,  
            'status'       => $this->status,  
        ]);
        
        //Sucesso
        return true;

    }

       /**
     * Método reponsável por atualizar o password
     *
     * @return void
     */
    public function updatePassword(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('racs'))->update('idRoot = '.$this->idRoot,[

            'password'     => $this->password,
          
        ]);
        
        //Sucesso
        return true;

    }


    /**
     * Método reponsável por deletar um usuário
     *
     * @return void
     */
    public function deleteRACS(){

        //Inserio os dados do cliete no banco de dados
        return (new Database('racs'))->delete('idRoot = '.$this->idRoot);
        
        //Sucesso
        return true;

    }
   /**
     * Método responsável por retornar um usuário pelo idRoot
     *
     * @param Intenger $idRoot
     * @return RACS
     */
    public static function getRACSById($idRoot){

        return self::getRACS('idRoot = '.$idRoot)->fetchObject(self::class);
    }
   
    /**
     * Método responsável por retotornar um usuário com base em seu email
     *
     * @param string $email
     * @return RACS
     */
    public static function getRACSByEmail($email){

      
        return (new Database('racs'))->select('email = "'.$email.'"')->fetchObject(self::class);
    }

     /**
     * Método responsavel por uma consulta customizada
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getRACS($where = null, $order = null, $limit = null, $fields = '*'){

        return(new Database('racs'))->select($where, $order, $limit, $fields);
    }

  
   
}