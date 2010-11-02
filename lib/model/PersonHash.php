<?php


/**
 * Skeleton subclass for representing a row from the 'person_hash' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sat Oct 30 00:00:27 2010
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class PersonHash extends BasePersonHash {
    /**
     * Get the hash's string
     * @return string
     */
    public function __toString() {
        return $this->getHash();
    }
    
    /**
     * Check if the hash is valid by age or usage
     * @return bool
     */
    public function isValid() {
        if ($this->isUsed() || $this->isOld()) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Check if 
     */
    public function isUsed() {
        return (bool) $this->getUsed();
    }
    
    /**
     * If the hash is old (ie: 30 minutes old)
     * @return bool
     */
    public function isOld() {
        return (bool) ((int)$this->getCreatedAt('U') < strtotime('-30 minutes'));
    }
    
    /**
     * Mark the hash as used
     */
    public function makeUsed() {
        $this->setUsed(1);
        $this->save();
    }
} // PersonHash
