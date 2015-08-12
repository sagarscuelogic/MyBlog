<?php

class PostController extends Zend_Controller_Action {

    protected $postModel;
    protected $authUserNameSpace;
    protected $userId;

    public function init() {
        /* Initialize action controller here */
        $this->authUserNameSpace = new Zend_Session_Namespace('Myblog_Auth');

        if (isset($this->authUserNameSpace->user->id) && $this->authUserNameSpace->user->id != "") {
            $this->user_id = $this->authUserNameSpace->user->id;
        }
        $this->postModel = new Myblog_Model_Post();        
    }

    public function indexAction() {
        // action body
    }

    public function listAction() {
        // action body
        if ($this->getRequest()->isXmlHttpRequest()) {
            $response = array(
                'status' => true
            );
            try {
                $userModel = new Myblog_Model_User();
                $response['count'] = $this->postModel->getMapper()->countAllRows();
                if ($response['count']) {
                    $posts = $this->postModel->getMapper()->fetchAllToArray();
                    foreach($posts as $post) {
                        $post['content'] = substr($post['content'], 0, 100);
                        
                        $post['author'] = $userModel->find($post['created_by'])->getName();
                        $post['lastUpdatedBy'] = $userModel->find($post['updated_by'])->getName();
                        unset($post['updated_by'], $post['updated_on']);
                        
                        $response['rows'][] = $post;
                    }
                }
            } catch (Exception $ex) {
                $response['status'] = false;
                $response['message'] = $ex->getMessage();
            }
            echo json_encode($response); exit;
        }
    }

    public function viewAction() {
        // action body
        $id = $this->_request->getParam('id');
        
        $post = $this->postModel->find($id);
        
        if($post) {
            $userUtil = new Myblog_Model_Utils_User();
            $commentModel = new Myblog_Model_Comment();
            $this->view->post = $post->toObject();
            $this->view->post->author = $userUtil->getNameById($post->getCreatedBy());
            $this->view->post->commentsCount = $commentModel->getMapper()->countByQuery('post = ' . $id . ' AND parent = 0');
        } else {
            $this->view->post = null;
        }
    }

    public function addAction() {
        // action body
    }

}
