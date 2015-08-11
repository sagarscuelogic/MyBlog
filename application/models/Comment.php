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
class Myblog_Model_Comment extends Myblog_Model_ModelAbstract
{

    /**
     * Database var type int(11) unsigned
     *
     * @var int
     */
    protected $_Id;

    /**
     * Database var type int(11) unsigned
     *
     * @var int
     */
    protected $_Post;

    /**
     * Database var type int(11)
     *
     * @var int
     */
    protected $_Parent;

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
     * Sets up column and relationship lists
     */
    public function __construct()
    {
        parent::init();
        $this->setColumnsList(array(
            'id'=>'Id',
            'post'=>'Post',
            'parent'=>'Parent',
            'content'=>'Content',
            'created_on'=>'CreatedOn',
            'created_by'=>'CreatedBy',
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
     * @return Myblog_Model_Comment
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
     * Sets column post
     *
     * @param int $data
     * @return Myblog_Model_Comment
     */
    public function setPost($data)
    {
        $this->_Post = $data;
        return $this;
    }

    /**
     * Gets column post
     *
     * @return int
     */
    public function getPost()
    {
        return $this->_Post;
    }

    /**
     * Sets column parent
     *
     * @param int $data
     * @return Myblog_Model_Comment
     */
    public function setParent($data)
    {
        $this->_Parent = $data;
        return $this;
    }

    /**
     * Gets column parent
     *
     * @return int
     */
    public function getParent()
    {
        return $this->_Parent;
    }

    /**
     * Sets column content
     *
     * @param string $data
     * @return Myblog_Model_Comment
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
     * @return Myblog_Model_Comment
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
     * @return Myblog_Model_Comment
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
     * Returns the mapper class for this model
     *
     * @return Myblog_Model_Mapper_Comment
     */
    public function getMapper()
    {
        if ($this->_mapper === null) {
            $this->setMapper(new Myblog_Model_Mapper_Comment());
        }

        return $this->_mapper;
    }

    /**
     * Deletes current row by deleting the row that matches the primary key
     *
	 * @see Myblog_Model_Mapper_Comment::delete
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
