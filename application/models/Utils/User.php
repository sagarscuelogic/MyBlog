<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author sagar
 */
class Myblog_Model_Utils_User {

    //put your code here
    public function getAllBloggers() {
        $returnValue = array();
        $userModel = new Myblog_Model_User();
        $userTable = $userModel->getMapper()->getDbTable();

        $select = $userTable->select()
                ->setIntegrityCheck(false)
                ->from(array('u' => 'user'), array('id', 'name', 'email'))
                ->join(array('p' => 'post'), 'p.created_by = u.id', array())
                ->group('u.id');

        $users = $userTable->fetchAll($select)->toArray();
        
        $returnValue['count'] = count($users);
        $returnValue['rows'] = $users;
        
        return $returnValue;
    }
    
    public function isAlreadyRegistered($email) {
        $userModel = new Myblog_Model_User();
        
        return count($userModel->getMapper()->findOneByField('email', $email));
    }
}
