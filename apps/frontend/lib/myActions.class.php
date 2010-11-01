<?php
abstract class myActions extends sfActions {
    /**
     * Sign in if possible
     */
    public function preExecute() {
        $r = $this->getRequest();
        if ($r->hasParameter('hash')) {
            $hash = $r->getParameter();
            $ph = PersonHashPeer::retrieveByPk($hash);
            if ($ph instanceof PersonHash && $ph->isValid()) {
                $this->getUser()->signIn($ph);
            } else {
                $this->getUser()->setFlash('Sorry, that hash has been used.');
                $this->redirect('@homepage');
            }
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