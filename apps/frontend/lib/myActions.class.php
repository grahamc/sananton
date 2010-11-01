<?php
abstract class myActions extends sfActions {
    /**
     * Sign in if possible
     */
    public function preExecute() {
        $r = $this->getRequest();
        
        $hash = $r->getUrlParameter('hash'); // Has no hasUrlParameter
        if ($hash !== null) {
            $ph = PersonHashPeer::retrieveByPk($hash);
            if ($ph instanceof PersonHash) {
                if ($this->getUser()->signIn($ph)) {
                    return true;
                }
            }
            
            // If a hash was passed and it isn't valid, continue
            $this->getUser()->setFlash('Sorry, that hash has been used.');
            $this->redirect('@homepage');
        }
    }
    
    public function forward404If($condition, $message = null) {
        if ($condition) {
            $this->getUser()->setFlash('error', $message);
            $this->redirect('@homepage');
        }
    }
    
    public function forward404Unless($condition, $message = null) {
        return $this->forward404If(!$condition, $message);
    }
}