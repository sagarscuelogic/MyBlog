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
 * Data Mapper implementation for Myblog_Model_User
 *
 * @package Myblog_Model
 * @subpackage Mapper
 * @author Sagar Sutaia
 */
class Myblog_Model_Mapper_User extends Myblog_Model_Mapper_MapperAbstract
{
    /**
     * Returns an array, keys are the field names.
     *
     * @param Myblog_Model_User $model
     * @return array
     */
    public function toArray($model)
    {
        if (! $model instanceof Myblog_Model_User) {
            throw new Exception('Unable to create array: invalid model passed to mapper');
        }

        $result = array(
            'id' => $model->getId(),
            'role' => $model->getRole(),
            'name' => $model->getName(),
            'email' => $model->getEmail(),
            'password' => $model->getPassword(),
            'created_on' => $model->getCreatedOn(),
            'created_by' => $model->getCreatedBy(),
            'updated_on' => $model->getUpdatedOn(),
            'updated_by' => $model->getUpdatedBy(),
        );

        return $result;
    }

    /**
     * Returns the DbTable class associated with this mapper
     *
     * @return Myblog_Model_DbTable_User
     */
    public function getDbTable()
    {
        if ($this->_dbTable === null) {
            $this->setDbTable('Myblog_Model_DbTable_User');
        }

        return $this->_dbTable;
    }

    /**
     * Deletes the current model
     *
     * @param Myblog_Model_User $model The model to delete
     * @param boolean $useTransaction Flag to indicate if delete should be done inside a database transaction
     * @see Myblog_Model_DbTable_TableAbstract::delete()
     * @return int
     */
    public function delete($model, $useTransaction = true)
    {
        if (! $model instanceof Myblog_Model_User) {
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
     * @param Myblog_Model_User $model
     * @param boolean $ignoreEmptyValues Should empty values saved
     * @param boolean $recursive Should the object graph be walked for all related elements
     * @param boolean $useTransaction Flag to indicate if save should be done inside a database transaction
     * @return boolean If the save action was successful
     */
    public function save(Myblog_Model_User $model,
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
     * @param Myblog_Model_User|null $model
     * @return Myblog_Model_User|null The object provided or null if not found
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
     * @param Myblog_Model_User|null $entry The object to load the data into, or null to have one created
     * @return Myblog_Model_User The model with the data provided
     */
    public function loadModel($data, $entry)
    {
        if ($entry === null) {
            $entry = new Myblog_Model_User();
        }

        if (is_array($data)) {
            $entry->setId($data['id'])
                  ->setRole($data['role'])
                  ->setName($data['name'])
                  ->setEmail($data['email'])
                  ->setPassword($data['password'])
                  ->setCreatedOn($data['created_on'])
                  ->setCreatedBy($data['created_by'])
                  ->setUpdatedOn($data['updated_on'])
                  ->setUpdatedBy($data['updated_by']);
        } elseif ($data instanceof Zend_Db_Table_Row_Abstract || $data instanceof stdClass) {
            $entry->setId($data->id)
                  ->setRole($data->role)
                  ->setName($data->name)
                  ->setEmail($data->email)
                  ->setPassword($data->password)
                  ->setCreatedOn($data->created_on)
                  ->setCreatedBy($data->created_by)
                  ->setUpdatedOn($data->updated_on)
                  ->setUpdatedBy($data->updated_by);
        }

        $entry->setMapper($this);

        return $entry;
    }
}
