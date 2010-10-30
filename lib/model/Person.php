<?php


/**
 * Skeleton subclass for representing a row from the 'person' table.
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
class Person extends BasePerson {
    public function __toString() {
        return $this->getName();
    }
    
    public function createHash() {
        $hash = new PersonHash();
        $hash->setPerson($this);
        $hash->setHash(md5(rand() . time() . uniqid()));
        $hash->save();
        
        return $hash;
    }
    
    /**
     * Get the filesystem image path
     */
    public function getImageFsPath() {
        return sfConfig::get('sf_upload_dir') . '/people/' . $this->getImage();
    }
    
    public function getImageWebPath() {
        return '/uploads/people/' . $this->getImage();
    }
    
    /**
     * Get categories for this person
     * @return array(Category, Category, ... )
     */
    public function getCategories() {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(PersonCategoryPeer::CATEGORY_ID);
        $rels = $this->getPersonCategorysJoinCategory($c);
        $cats = array();
        foreach ($rels as $rel) {
            $cats[] = $rel->getCategory();
        }
        
        return $cats;
    }
    
    public function save(PropelPDO $con = null) {
        if (in_array(PersonPeer::IMAGE, $this->modifiedColumns)) {
            // Re-size their image now
            //$thumbnailer = new sfThumbnail(null, 200);
            $thumbnailer = new sfThumbnail(200, 200, false, true, 75, 'sfImageMagickAdapter', array('method' => 'shave_bottom'));
            $thumbnailer->loadFile($this->getImageFsPath());
            $thumbnailer->save($this->getImageFsPath());
        }
        
        return parent::save($con);
    }
} // Person
