<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author sagar
 */
class Myblog_Model_Utils_Comment {

    //put your code here
    public function getCommentHierarchyByPost($postId = null) {
        if (!$postId)
            return false;
        $response = array();
        $commentModel = new Myblog_Model_Comment();
        $comments = $commentModel->getMapper()->findByField(array('post', 'parent'), array('post' => $postId, 'parent' => 0));

        if ($comments) {
            $userUtils = new Myblog_Model_Utils_User();
            foreach ($comments as $comment) {
                $comment = $comment->toArray();
                $comment['children'] = $this->getChildren($postId, $comment['id']);
                $response[] = $comment;
            }
        }
        return $response;
    }

    protected function getChildren($post, $parent) {
        try {
            $response = array();
            $commentModel = new Myblog_Model_Comment();
            $comments = $commentModel->getMapper()->findByField(array('post', 'parent'), array('post' => $post, 'parent' => $parent));
            if ($comments) {
                $userUtils = new Myblog_Model_Utils_User();
                foreach ($comments as $comment) {
                    $comment = $comment->toArray();
                    $comment['children'] = $this->getChildren($post, $comment['id']);
                    $response[] = $comment;
                }
            }
            return $response;
        } catch (Exception $ex) {
            echo $post, ' # ', $parent;
            exit;
        }
    }

}
