<?php

class myUser extends sfBasicSecurityUser
{
    /**
     * The hash used for the current user
     * @var PersonHash
     */
    protected $hash = null;
    
    /**
     * Log in as a hash if the hash is valid
     * @return bool
     */
    public function signIn(PersonHash $hash) {
        if (!$hash->isValid()) {
            return false;
        }
        
        $this->hash = $hash;
        $this->setAttribute('hash', $hash->getHash());
        $this->setAuthenticated(true);
        
        return true;
    }
    
    /**
     * Deauthenticate and invalidate the auth token
     */
    public function signOut() {
        // Invalidate the token
        if ($this->getHash() instanceof PersonHash) {
            $this->getHash()->makeUsed();
        }
        
        // Remove their information
        $this->hash = null;
        $this->setAttribute('hash', null);
        $this->setAuthenticated(false);
    }
    
    /**
     * Get the Person record currently logged in
     * @return Person|false[if not logged in]
     */
    public function getPerson() {
        if (!$this->getHash()) {
            return false;
        }
        
        return $this->getHash()->getPerson();
    }
    
    /**
     * Get the PersonHash object which is currently logged in
     * @return Personhash|false[if not logged in]
     */
    public function getHash() {
        if (!$this->isAuthenticated()) {
            return false;
        }
        
        if ($this->hash === null) {
            return $this->retrieveHash();
        }
        
        return $this->hash;
    }
    
    /**
     * Load the hash object for the logged in user on subsequent requests
     * Sign them out if the hash is old or invalidated
     *
     * @return PersonHash|false[upon failure]
     */
    protected function retrieveHash() {
        $this->hash = PersonHashPeer::retrieveByPk($this->getAttribute('hash'));
        if (!$this->hash instanceof PersonHash || !$this->hash->isValid()) {
            $this->signOut();
        }
        
        return $this->hash;
    }
}
