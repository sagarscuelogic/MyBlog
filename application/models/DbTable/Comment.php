<?php

/**
 * Application Model DbTables
 *
 * @package Myblog_Model
 * @subpackage DbTable
 * @author Sagar Sutaia
 * @copyright sagar.sutaria@cuelogic.co.in
 * @license http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * Table definition for comment
 *
 * @package Myblog_Model
 * @subpackage DbTable
 * @author Sagar Sutaia
 */
class Myblog_Model_DbTable_Comment extends Myblog_Model_DbTable_TableAbstract
{
    /**
     * $_name - name of database table
     *
     * @var string
     */
    protected $_name = 'comment';

    /**
     * $_id - this is the primary key name
     *
     * @var int
     */
    protected $_id = 'id';

    protected $_sequence = true;

    
    



}
