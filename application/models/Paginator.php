<?php

/**
 *
 * @package Myblog_Model
 * @subpackage Paginator
 * @author Sagar Sutaia
 * @copyright sagar.sutaria@cuelogic.co.in
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * Paginator class that extends Zend_Paginator_Adapter_DbSelect to return an
 * object instead of an array.
 *
 * @package Myblog_Model
 * @subpackage Paginator
 * @author Sagar Sutaia
 */
class Myblog_Model_Paginator extends Zend_Paginator_Adapter_DbSelect
{
    /**
     * Object mapper
     *
     * @var Myblog_Model_MapperAbstract
     */
    protected $_mapper = null;

    /**
     * Constructor.
     *
     * @param Zend_Db_Select $select The select query
     * @param Myblog_Model_MapperAbstract $mapper The mapper associated with the object type
     */
    public function __construct(Zend_Db_Select $select, Myblog_Model_Mapper_MapperAbstract $mapper)
    {
        $this->_mapper = $mapper;
        parent::__construct($select);
    }

    /**
     * Returns an array of items as objects for a page.
     *
     * @param  integer $offset Page offset
     * @param  integer $itemCountPerPage Number of items per page
     * @return array An array of Myblog_ModelAbstract objects
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $items = parent::getItems($offset, $itemCountPerPage);
        $objects = array();

        foreach ($items as $item) {
            $objects[] = $this->_mapper->loadModel($item, null);
        }

        return $objects;
    }
}
