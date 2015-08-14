<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initLogger() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $resources = $config->resources;
        $resources = $resources->toArray();
        $writer = new Zend_Log_Writer_Stream($resources["log"]["stream"]["writerParams"]["stream"], $resources["log"]["stream"]["writerParams"]["mode"]);
        $logger = new Zend_Log($writer);
        Zend_Registry::set('logger', $logger);
    }

    protected function _initLoadAclIni() {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/acl.ini');
        Zend_Registry::set('acl', $config);
    }

    protected function _initAclControllerPlugin() {
        $this->bootstrap('frontcontroller');
        $this->bootstrap('loadAclIni');

        $front = Zend_Controller_Front::getInstance();

        $aclPlugin = new Myblog_Model_Utils_AclPlugin(new Myblog_Model_Utils_Acl());

        $front->registerPlugin($aclPlugin);
    }

}
