<?php


/**
 * Skeleton subclass for performing query and update operations on the 'person' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Fri Oct 29 15:44:41 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PersonPeer extends BasePersonPeer {
    /**
     * Get active users by page
     * @param int $page which page to retrieve
     * @param int $per_page how many to retrieve per page
     */
    public static function getActiveByPage($page = 1, $per_page = 15, Criteria $c = null) {
        if ($c instanceof Criteria) {
            $c = clone $c;
        } else {
            $c = new Criteria();            
        }
        
        $c->setLimit($per_page);
        $c->setOffset(($page - 1) * $per_page);
        
        return self::getActive($c);
    }
    
    /**
     * Get active people, which are to be displayed
     * @param Criteria $c
     * @return array(Person, Person, ...)
     */
    public static function getActive(Criteria $c = null) {
        if ($c instanceof Criteria) {
            $c = clone $c;
        } else {
            $c = new Criteria();            
        }
        
        $c->add(PersonPeer::VALIDATED_AT, null, Criteria::ISNOTNULL);
        return PersonPeer::doSelect($c);
    }
    
    /**
     * Count active users
     * @param Criteria $c
     * @return integer
     */
    public static function countActive(Criteria $c = null) {
        if ($c instanceof Criteria) {
            $c = clone $c;
        } else {
            $c = new Criteria();            
        }
        
        $c->add(PersonPeer::VALIDATED_AT, null, Criteria::ISNOTNULL);
        return PersonPeer::doCount($c);
    }
} // PersonPeer
