<?php

class PostController extends Zend_Controller_Action {

    protected $postModel;
    protected $authUserNameSpace;
    protected $userId;

    public function init() {
        /* Initialize action controller here */
        $this->authUserNameSpace = new Zend_Session_Namespace('Myblog_Auth');

        if (isset($this->authUserNameSpace->userId) && $this->authUserNameSpace->userId != "") {
            $this->user_id = $this->authUserNameSpace->userId;
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
    }

    public function addAction() {
        // action body
    }

}
