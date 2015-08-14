<?php

class CommentController extends Zend_Controller_Action {

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
        if ($this->_request->isXmlHttpRequest()) {
            $postId = $this->_request->getParam('post', null);
            $response = array(
                'status' => true
            );
            if ($postId) {
                $commentUtils = new Myblog_Model_Utils_Comment();
                $response['rows'] = $commentUtils->getCommentHierarchyByPost($postId);
            }
            echo json_encode($response);
            exit;
        }
    }

    public function addAction() {
        // action body
        if ($this->_request->isXmlHttpRequest()) {
            $response = array(
                'status' => true
            );
            if (!isset($this->authUserNameSpace->user->id) || !$this->authUserNameSpace->user->id != "") {
                $response['status'] = false;
                $response['message'] = 'You have to be logged in to be able to comment to the post';
            } else {
                $postId = $this->_request->getParam('postId');
                $content = $this->_request->getParam('comment');
                $parent = $this->_request->getParam('commentId');

                $commentModel = new Myblog_Model_Comment();
                $commentModel->setContent(trim($content));
                $commentModel->setPost($postId);
                $commentModel->setParent($parent);
                $commentModel->setCreatedOn('');
                $commentModel->setCreatedBy($this->authUserNameSpace->user->id);
                $saveResult = $commentModel->save();

                if ($saveResult) {
                    $response['status'] = true;
                    $response['id'] = $saveResult;
                }
            }
            echo json_encode($response);
            exit;
        }
    }

    public function deleteAction() {
        // action body

        if ($this->_request->isXmlHttpRequest()) {
            $commentModel = new Myblog_Model_Comment();
            $id = $this->_request->getParam('id');

            $response = array(
                'status' => true
            );

            if ($id) {
                $response['status'] = boolval($commentModel->deleteRowByPrimaryKey($id));
            }
            echo json_encode($response);
            exit;
        }
    }

}
