<?php
class authenticateActions extends myActions {
    /**
     * Handle a request for authenticating a user
     */
    public function executeRequest(sfWebRequest $request) {
        if ($request->hasParameter('email')) {
            $email = $request->getParameter('email');
            $person = PersonPeer::getByEmail($email);
            $this->forward404Unless($person instanceof Person, 'No such email address, sorry.');
        
            // Send them a login link
            $hash = $person->createHash();
            $msg = new PersonEditMessage($hash);
            $this->getMailer()->send($msg);
            
            $this->getUser()->setFlash('success', 'Almost there! Just check your email address and click the edit link.');
            $this->redirect('@homepage');
        }
    }
    
    /**
     * Log in the user if possible and redirect them to their
     * destination depending on if their user is validated or not.
     */
    public function executeLogin(sfWebRequest $request) {
        $r = $this->attemptLogin($request);
        $this->forward404Unless($r, 'Your link has been used, sorry.');
        
        if ($this->getUser()->getPerson()->isValidated()) {
            $this->redirect('@person_edit');            
        } else {
            $this->redirect('@person_validate');
        }
    }
    
    /**
     * Log out and redirect to the homepage
     */
    public function executeLogout(sfWebRequest $request) {
        $this->getUser()->signOut();
        $this->redirect('@homepage');
    }
    
    /**
     * Attempt to log in using the request information.
     * @return bool
     */
    protected function attemptLogin(sfWebRequest $request) {
        $hash = $request->getUrlParameter('hash'); // Has no hasUrlParameter
        if ($hash !== null) {
            $ph = PersonHashPeer::retrieveByPk($hash);
            if ($ph instanceof PersonHash) {
                if ($this->getUser()->signIn($ph)) {
                    return true;
                }
            }
        }
        
        return false;
    }
}