<?php

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Define application environment
defined('DATABASE_ENCRYPTION_KEY') || define('DATABASE_ENCRYPTION_KEY', (getenv('DATABASE_ENCRYPTION_KEY') ? getenv('DATABASE_ENCRYPTION_KEY') : 'dnj'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// router information for standard and custom routes
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Controller/Router/Route.php';
require_once 'Zend/Rest/Route.php';

$ctrl = Zend_Controller_Front::getInstance();
$router = $ctrl->getRouter();

// Homepage
$router->addRoute('home', new Zend_Controller_Router_Route('/', array('module' => 'default', 'controller' => 'homepage', 'action' => 'index')));

// Login
$router->addRoute('login', new Zend_Controller_Router_Route('/login', array('module' => 'default', 'controller' => 'homepage', 'action' => 'login')));
$router->addRoute('register', new Zend_Controller_Router_Route('/register', array('module' => 'default', 'controller' => 'homepage', 'action' => 'register')));
$router->addRoute('logout', new Zend_Controller_Router_Route('/logout', array('module' => 'default', 'controller' => 'homepage', 'action' => 'logout')));

// Posts
$router->addRoute('post_list', new Zend_Controller_Router_Route('/post', array('module' => 'default', 'controller' => 'post', 'action' => 'list')));
$router->addRoute('post_add', new Zend_Controller_Router_Route('/post/add', array('module' => 'default', 'controller' => 'post', 'action' => 'add')));
$router->addRoute('post_edit', new Zend_Controller_Router_Route('/post/edit/:id', array('module' => 'default', 'controller' => 'post', 'action' => 'add')));
$router->addRoute('post_view', new Zend_Controller_Router_Route('/post/:id', array('module' => 'default', 'controller' => 'post', 'action' => 'view')));

// Comments
$router->addRoute('comment_list', new Zend_Controller_Router_Route('/comment', array('module' => 'default', 'controller' => 'comment', 'action' => 'list')));
$router->addRoute('comment_add', new Zend_Controller_Router_Route('/comment/add', array('module' => 'default', 'controller' => 'comment', 'action' => 'add')));
$router->addRoute('comment_edit', new Zend_Controller_Router_Route('/comment/edit/:id', array('module' => 'default', 'controller' => 'comment', 'action' => 'add')));
$router->addRoute('comment_delete', new Zend_Controller_Router_Route('/comment/delete/:id', array('module' => 'default', 'controller' => 'comment', 'action' => 'delete')));

// Users
$router->addRoute('blogger', new Zend_Controller_Router_Route('/bloggers', array('module' => 'default', 'controller' => 'user', 'action' => 'list')));
$router->addRoute('myprofile', new Zend_Controller_Router_Route('/myprofile', array('module' => 'default', 'controller' => 'user', 'action' => 'myprofile')));
$router->addRoute('user_view', new Zend_Controller_Router_Route('/user/:id', array('module' => 'default', 'controller' => 'user', 'action' => 'view')));
$router->addRoute('user_add', new Zend_Controller_Router_Route('/user/add', array('module' => 'default', 'controller' => 'user', 'action' => 'add')));

// Admin: Post
$router->addRoute('admin_post_list', new Zend_Controller_Router_Route('/admin/post', array('module' => 'admin', 'controller' => 'post', 'action' => 'list')));
$router->addRoute('admin_post_edit', new Zend_Controller_Router_Route('/admin/post/edit/:id', array('module' => 'admin', 'controller' => 'post', 'action' => 'add')));
$router->addRoute('admin_post_view', new Zend_Controller_Router_Route('/admin/post/:id', array('module' => 'admin', 'controller' => 'post', 'action' => 'view')));
$router->addRoute('admin_post_add', new Zend_Controller_Router_Route('/admin/post/add', array('module' => 'admin', 'controller' => 'post', 'action' => 'add')));

// Admin: User
$router->addRoute('admin_user_list', new Zend_Controller_Router_Route('/admin/user', array('module' => 'admin', 'controller' => 'user', 'action' => 'list')));
$router->addRoute('admin_user_edit', new Zend_Controller_Router_Route('/admin/user/edit/:id', array('module' => 'admin', 'controller' => 'user', 'action' => 'add')));
$router->addRoute('admin_user_view', new Zend_Controller_Router_Route('/admin/user/:id', array('module' => 'admin', 'controller' => 'user', 'action' => 'view')));
$router->addRoute('admin_user_add', new Zend_Controller_Router_Route('/admin/user/add', array('module' => 'admin', 'controller' => 'user', 'action' => 'add')));

// Create application, bootstrap, and run
$application = new Zend_Application(
        APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
        ->run();
