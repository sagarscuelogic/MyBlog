<?php

class UserController extends Zend_Controller_Action
{

    protected $userUtil = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->userUtil = new Myblog_Model_Utils_User();
    }

    public function indexAction()
    {
        // action body
    }

    public function viewAction()
    {
        // action body
    }

    public function addAction()
    {
        // action body
        if ($this->_request->isXmlHttpRequest()) {
            $name = $this->_request->getParam('inputName');
            $email = $this->_request->getParam('inputEmail');
            $password = $this->_request->getParam('inputPassword');

            $response = array(
                'status' => true
            );

            if ($this->userUtil->isAlreadyRegistered($email)) {
                $response['status'] = false;
                $response['message'] = 'Email already registered';
                $response['errorFields'][] = 'inputEmail';
            } else {
                $userModel = new Myblog_Model_User();
                $userModel->setName(trim($name));
                $userModel->setEmail(trim($email));
                $userModel->setPassword(md5($password));
                $userModel->setCreatedOn(null);
                $userModel->setUpdatedOn(null);
                $saveResult = $userModel->save(true, false, true);
                if ($saveResult) {
                    $response['id'] = $saveResult;
                    $response['status'] = true;
                } else {
                    $response['status'] = false;
                    $response['message'] = 'Email already registered';
                }
            }

            echo json_encode($response);
            exit;
        }
        
    }

    public function listAction()
    {
        // action body
        $bloggers = $this->userUtil->getAllBloggers();

        $this->view->bloggers = $bloggers;
    }

    public function myprofileAction()
    {
        // action body
    }


}


