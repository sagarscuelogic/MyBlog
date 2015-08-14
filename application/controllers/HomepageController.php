<?php

class HomepageController extends Zend_Controller_Action {

    protected $authUser_NameSpace = null;

    public function init() {
        /* Initialize action controller here */
        $this->authUser_NameSpace = new Zend_Session_Namespace('Myblog_Auth');
    }

    public function indexAction() {
        // action body
    }

    public function loginAction() {
        // action body
        if (isset($this->authUser_NameSpace->user->id)) {
            $this->_redirect('/');
        }
        if ($this->_request->isXmlHttpRequest() && $this->_request->isPost()) {
            $username = $this->_request->getParam('inputEmail');
            $password = $this->_request->getParam('inputPassword');
            $userUtil = new Myblog_Model_Utils_User();
            $userModel = $userUtil->authenticate($username, $password);
            $response = array(
                'status' => true
            );
            if ($userModel) {
                $this->authUser_NameSpace->user = $userModel->toObject();
                $this->authUser_NameSpace->acl = new Myblog_Model_Utils_Acl();
            } else {
                $response['status'] = false;
                $response['message'] = 'Login failed';
            }
            echo json_encode($response);
            exit;
        }
    }

    public function registerAction() {
        // action body
    }

    public function logoutAction() {
        // action body
        if ($this->_request->isXmlHttpRequest()) {
            try {
                unset($this->authUser_NameSpace->user);
                echo json_encode(array('status' => true));
            } catch (Exception $ex) {
                echo json_encode(array('status' => false, 'message' => $ex->getMessage()));
            }
            exit;
        }
    }

}
