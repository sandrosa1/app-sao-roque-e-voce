<?php

namespace App\Password;

use \App\Model\Entity\Customer\Customer;
use App\Model\Entity\RACS\RACS;

class Password{

    
    /**
     * Criar o hash da senha para salvar no banco de dados
     *
     * @paramString $senha
     * @return String
     */
    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    /**
     * Metódo responsável em verificar se o hash da senha do cliente esta correto
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function verifyHashCustomer($email,$password)
    {
        $objCustomer = Customer::getCustomerByEmail($email);
    
        if(!password_verify($password, $objCustomer->password)){
          
            return false;
        }
        return true;
    }
     /**
     * Metódo responsável em verificar se o hash da senha do cliente esta correto
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function verifyHashRacs($email,$password)
    {
        $objCustomer = RACS::getRacsByEmail($email);
    
        if(!password_verify($password,$objCustomer->password)){
          
            return false;
        }
        return true;
    }
}