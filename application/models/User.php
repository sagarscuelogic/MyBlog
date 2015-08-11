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
class Myblog_Model_User extends Myblog_Model_ModelAbstract
{

    /**
     * Database var type int(11) unsigned
     *
     * @var int
     */
    protected $_Id;

    /**
     * Database var type enum('public','author','admin','')
     *
     * @var string
     */
    protected $_Role;

    /**
     * Database var type varchar(255)
     *
     * @var string
     */
    protected $_Name;

    /**
     * Database var type varchar(255)
     *
     * @var string
     */
    protected $_Email;

    /**
     * Database var type varbinary(255)
     *
     * @var binary
     */
    protected $_Password;

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
            'role'=>'Role',
            'name'=>'Name',
            'email'=>'Email',
            'password'=>'Password',
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
     * @return Myblog_Model_User
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
     * Sets column role
     *
     * @param string $data
     * @return Myblog_Model_User
     */
    public function setRole($data)
    {
        $this->_Role = $data;
        return $this;
    }

    /**
     * Gets column role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->_Role;
    }

    /**
     * Sets column name
     *
     * @param string $data
     * @return Myblog_Model_User
     */
    public function setName($data)
    {
        $this->_Name = $data;
        return $this;
    }

    /**
     * Gets column name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_Name;
    }

    /**
     * Sets column email
     *
     * @param string $data
     * @return Myblog_Model_User
     */
    public function setEmail($data)
    {
        $this->_Email = $data;
        return $this;
    }

    /**
     * Gets column email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_Email;
    }

    /**
     * Sets column password
     *
     * @param binary $data
     * @return Myblog_Model_User
     */
    public function setPassword($data)
    {
        $this->_Password = $data;
        return $this;
    }

    /**
     * Gets column password
     *
     * @return binary
     */
    public function getPassword()
    {
        return $this->_Password;
    }

    /**
     * Sets column created_on. Stored in ISO 8601 format.
     *
     * @param string|Zend_Date $date
     * @return Myblog_Model_User
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
     * @return Myblog_Model_User
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
     * @return Myblog_Model_User
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
     * @return Myblog_Model_User
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
     * @return Myblog_Model_Mapper_User
     */
    public function getMapper()
    {
        if ($this->_mapper === null) {
            $this->setMapper(new Myblog_Model_Mapper_User());
        }

        return $this->_mapper;
    }

    /**
     * Deletes current row by deleting the row that matches the primary key
     *
	 * @see Myblog_Model_Mapper_User::delete
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
