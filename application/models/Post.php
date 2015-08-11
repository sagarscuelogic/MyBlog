<?php

/**
 * Application Models
 *
 * @package Myblog_Model
 * @subpackage Model
 * @author Sagar Sutaia
 * @copyright sagar.sutaria@cuelogic.co.in
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 */


/**
 * 
 *
 * @package Myblog_Model
 * @subpackage Model
 * @author Sagar Sutaia
 */
class Myblog_Model_Post extends Myblog_Model_ModelAbstract
{

    /**
     * Database var type int(11) unsigned
     *
     * @var int
     */
    protected $_Id;

    /**
     * Database var type varchar(255)
     *
     * @var string
     */
    protected $_Title;

    /**
     * Database var type text
     *
     * @var string
     */
    protected $_Content;

    /**
     * Database var type datetime
     *
     * @var string
     */
    protected $_CreatedOn;

    /**
     * Database var type int(11)
     *
     * @var int
     */
    protected $_CreatedBy;

    /**
     * Database var type datetime
     *
     * @var string
     */
    protected $_UpdatedOn;

    /**
     * Database var type int(11)
     *
     * @var int
     */
    protected $_UpdatedBy;



    /**
     * Sets up column and relationship lists
     */
    public function __construct()
    {
        parent::init();
        $this->setColumnsList(array(
            'id'=>'Id',
            'title'=>'Title',
            'content'=>'Content',
            'created_on'=>'CreatedOn',
            'created_by'=>'CreatedBy',
            'updated_on'=>'UpdatedOn',
            'updated_by'=>'UpdatedBy',
        ));

        $this->setParentList(array(
        ));

        $this->setDependentList(array(
        ));
    }

    /**
     * Sets column id
     *
     * @param int $data
     * @return Myblog_Model_Post
     */
    public function setId($data)
    {
        $this->_Id = $data;
        return $this;
    }

    /**
     * Gets column id
     *
     * @return int
     */
    public function getId()
    {
        return $this->_Id;
    }

    /**
     * Sets column title
     *
     * @param string $data
     * @return Myblog_Model_Post
     */
    public function setTitle($data)
    {
        $this->_Title = $data;
        return $this;
    }

    /**
     * Gets column title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_Title;
    }

    /**
     * Sets column content
     *
     * @param string $data
     * @return Myblog_Model_Post
     */
    public function setContent($data)
    {
        $this->_Content = $data;
        return $this;
    }

    /**
     * Gets column content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->_Content;
    }

    /**
     * Sets column created_on. Stored in ISO 8601 format.
     *
     * @param string|Zend_Date $date
     * @return Myblog_Model_Post
     */
    public function setCreatedOn($data)
    {
        if (! empty($data)) {
            if (! $data instanceof Zend_Date) {
                $data = new Zend_Date($data);
            }

            $data = $data->toString('YYYY-MM-ddTHH:mm:ss.S');
        }

        $this->_CreatedOn = $data;
        return $this;
    }

    /**
     * Gets column created_on
     *
     * @param boolean $returnZendDate
     * @return Zend_Date|null|string Zend_Date representation of this datetime if enabled, or ISO 8601 string if not
     */
    public function getCreatedOn($returnZendDate = false)
    {
        if ($returnZendDate) {
            if ($this->_CreatedOn === null) {
                return null;
            }

            return new Zend_Date($this->_CreatedOn, 'YYYY-MM-ddTHH:mm:ss.S');
        }

        return $this->_CreatedOn;
    }

    /**
     * Sets column created_by
     *
     * @param int $data
     * @return Myblog_Model_Post
     */
    public function setCreatedBy($data)
    {
        $this->_CreatedBy = $data;
        return $this;
    }

    /**
     * Gets column created_by
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->_CreatedBy;
    }

    /**
     * Sets column updated_on. Stored in ISO 8601 format.
     *
     * @param string|Zend_Date $date
     * @return Myblog_Model_Post
     */
    public function setUpdatedOn($data)
    {
        if (! empty($data)) {
            if (! $data instanceof Zend_Date) {
                $data = new Zend_Date($data);
            }

            $data = $data->toString('YYYY-MM-ddTHH:mm:ss.S');
        }

        $this->_UpdatedOn = $data;
        return $this;
    }

    /**
     * Gets column updated_on
     *
     * @param boolean $returnZendDate
     * @return Zend_Date|null|string Zend_Date representation of this datetime if enabled, or ISO 8601 string if not
     */
    public function getUpdatedOn($returnZendDate = false)
    {
        if ($returnZendDate) {
            if ($this->_UpdatedOn === null) {
                return null;
            }

            return new Zend_Date($this->_UpdatedOn, 'YYYY-MM-ddTHH:mm:ss.S');
        }

        return $this->_UpdatedOn;
    }

    /**
     * Sets column updated_by
     *
     * @param int $data
     * @return Myblog_Model_Post
     */
    public function setUpdatedBy($data)
    {
        $this->_UpdatedBy = $data;
        return $this;
    }

    /**
     * Gets column updated_by
     *
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->_UpdatedBy;
    }

    /**
     * Returns the mapper class for this model
     *
     * @return Myblog_Model_Mapper_Post
     */
    public function getMapper()
    {
        if ($this->_mapper === null) {
            $this->setMapper(new Myblog_Model_Mapper_Post());
        }

        return $this->_mapper;
    }

    /**
     * Deletes current row by deleting the row that matches the primary key
     *
	 * @see Myblog_Model_Mapper_Post::delete
     * @return int|boolean Number of rows deleted or boolean if doing soft delete
     */
    public function deleteRowByPrimaryKey()
    {
        if ($this->getId() === null) {
            throw new Exception('Primary Key does not contain a value');
        }

        return $this->getMapper()
                    ->getDbTable()
                    ->delete('id = ' .
                             $this->getMapper()
                                  ->getDbTable()
                                  ->getAdapter()
                                  ->quote($this->getId()));
    }
}
