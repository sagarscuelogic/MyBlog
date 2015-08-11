<?php

/**
 * Application Model Mappers
 *
 * @package Myblog_Model
 * @subpackage Mapper
 * @author Sagar Sutaia
 * @copyright sagar.sutaria@cuelogic.co.in
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * Data Mapper implementation for Myblog_Model_Comment
 *
 * @package Myblog_Model
 * @subpackage Mapper
 * @author Sagar Sutaia
 */
class Myblog_Model_Mapper_Comment extends Myblog_Model_Mapper_MapperAbstract
{
    /**
     * Returns an array, keys are the field names.
     *
     * @param Myblog_Model_Comment $model
     * @return array
     */
    public function toArray($model)
    {
        if (! $model instanceof Myblog_Model_Comment) {
            throw new Exception('Unable to create array: invalid model passed to mapper');
        }

        $result = array(
            'id' => $model->getId(),
            'post' => $model->getPost(),
            'parent' => $model->getParent(),
            'content' => $model->getContent(),
            'created_on' => $model->getCreatedOn(),
            'created_by' => $model->getCreatedBy(),
        );

        return $result;
    }

    /**
     * Returns the DbTable class associated with this mapper
     *
     * @return Myblog_Model_DbTable_Comment
     */
    public function getDbTable()
    {
        if ($this->_dbTable === null) {
            $this->setDbTable('Myblog_Model_DbTable_Comment');
        }

        return $this->_dbTable;
    }

    /**
     * Deletes the current model
     *
     * @param Myblog_Model_Comment $model The model to delete
     * @param boolean $useTransaction Flag to indicate if delete should be done inside a database transaction
     * @see Myblog_Model_DbTable_TableAbstract::delete()
     * @return int
     */
    public function delete($model, $useTransaction = true)
    {
        if (! $model instanceof Myblog_Model_Comment) {
            throw new Exception('Unable to delete: invalid model passed to mapper');
        }

        if ($useTransaction) {
            $this->getDbTable()->getAdapter()->beginTransaction();
        }
        try {
            $where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $model->getId());
            $result = $this->getDbTable()->delete($where);

            if ($useTransaction) {
                $this->getDbTable()->getAdapter()->commit();
            }
        } catch (Exception $e) {
            if ($useTransaction) {
                $this->getDbTable()->getAdapter()->rollback();
            }
            $result = false;
        }

        return $result;
    }

    /**
     * Saves current row, and optionally dependent rows
     *
     * @param Myblog_Model_Comment $model
     * @param boolean $ignoreEmptyValues Should empty values saved
     * @param boolean $recursive Should the object graph be walked for all related elements
     * @param boolean $useTransaction Flag to indicate if save should be done inside a database transaction
     * @return boolean If the save action was successful
     */
    public function save(Myblog_Model_Comment $model,
        $ignoreEmptyValues = true, $recursive = false, $useTransaction = true
    ) {
        $data = $model->toArray();
        if ($ignoreEmptyValues) {
            foreach ($data as $key => $value) {
                if ($value === null or $value === '') {
                    unset($data[$key]);
                }
            }
        }

        $primary_key = $model->getId();
        $success = true;

        if ($useTransaction) {
            $this->getDbTable()->getAdapter()->beginTransaction();
        }

        unset($data['id']);

        try {
            if ($primary_key === null) {
                $primary_key = $this->getDbTable()->insert($data);
                if ($primary_key) {
                    $model->setId($primary_key);
                    $success = $primary_key;
                } else {
                    $success = false;
                }
            } else {
                $this->getDbTable()
                     ->update($data,
                              array(
                                 'id = ?' => $primary_key
                              )
                );
            }

            if ($useTransaction && $success) {
                $this->getDbTable()->getAdapter()->commit();
            } elseif ($useTransaction) {
                $this->getDbTable()->getAdapter()->rollback();
            }

        } catch (Exception $e) {
            if ($useTransaction) {
                $this->getDbTable()->getAdapter()->rollback();
            }

            $success = false;
        }

        return $success;
    }

    /**
     * Finds row by primary key
     *
     * @param int $primary_key
     * @param Myblog_Model_Comment|null $model
     * @return Myblog_Model_Comment|null The object provided or null if not found
     */
    public function find($primary_key, $model)
    {
        $result = $this->getRowset($primary_key);

        if (is_null($result)) {
            return null;
        }

        $row = $result->current();

        $model = $this->loadModel($row, $model);

        return $model;
    }

    /**
     * Loads the model specific data into the model object
     *
     * @param Zend_Db_Table_Row_Abstract|array $data The data as returned from a Zend_Db query
     * @param Myblog_Model_Comment|null $entry The object to load the data into, or null to have one created
     * @return Myblog_Model_Comment The model with the data provided
     */
    public function loadModel($data, $entry)
    {
        if ($entry === null) {
            $entry = new Myblog_Model_Comment();
        }

        if (is_array($data)) {
            $entry->setId($data['id'])
                  ->setPost($data['post'])
                  ->setParent($data['parent'])
                  ->setContent($data['content'])
                  ->setCreatedOn($data['created_on'])
                  ->setCreatedBy($data['created_by']);
        } elseif ($data instanceof Zend_Db_Table_Row_Abstract || $data instanceof stdClass) {
            $entry->setId($data->id)
                  ->setPost($data->post)
                  ->setParent($data->parent)
                  ->setContent($data->content)
                  ->setCreatedOn($data->created_on)
                  ->setCreatedBy($data->created_by);
        }

        $entry->setMapper($this);

        return $entry;
    }
}
