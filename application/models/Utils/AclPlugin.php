<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclPlugin
 *
 * @author sagar
 */
class Myblog_Model_Utils_AclPlugin extends Zend_Controller_Plugin_Abstract {

    /**
     *
     * @var Zend_Auth
     */
    protected $_auth;
    protected $_acl;
    protected $_action;
    protected $_controller;
    protected $_currentRole;

    public function __construct(Zend_Acl $acl, array $options = array()) {
        $this->_auth = new Zend_Session_Namespace('Myblog_Auth');
        $this->_acl = $acl;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {

        $this->_init($request);

        // if the current user role is not allowed to do something
        if (!$this->_acl->isAllowed($this->_currentRole, $this->_controller, $this->_action)) {

            if ('guest' == $this->_currentRole) {
                $request->setControllerName('user');
                $request->setActionName('login');
            } else {
                $request->setControllerName('error');
                $request->setActionName('error');
                if (isset($error) && $error != "") {
                    $request->setParam('error_handler', 'acl_error');
                    $request->setParam('message', "Sorry, the page you requested does not exist or you do not have access");
                }
            }
        }
    }

    protected function _init($request) {
        $this->_action = $request->getActionName();
        $this->_controller = $request->getControllerName();
        $this->_currentRole = $this->_getCurrentUserRole();
    }

    protected function _getCurrentUserRole() {
        if (isset($this->_auth->user->id)) {
            $role = isset($this->_auth->user->role) ? strtolower($this->_auth->user->role) : 'guest';
        } else {
            $role = 'guest';
        }

        return $role;
    }

}
