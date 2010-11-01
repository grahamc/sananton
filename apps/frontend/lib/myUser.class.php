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
        $this->hash->makeUsed();
        
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
        if (!$this->isAuthenticated()) {
            return false;
        }
        
        return $this->getHash()->getPerson();
    }
    
    /**
     * Get the PersonHash object which is currently logged in
     * @return Personhash|falsep[if not logged in]
     */
    public function getHash() {
        if (!$this->isAuthenticated()) {
            return false;
        }
        
        return $this->hash;
    }
}
