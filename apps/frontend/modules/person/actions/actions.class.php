<?php
class personActions extends myActions {
    /**
     * Validate the person and then log out
     */
    public function executeValidate(sfWebRequest $request) {
        $p = $this->getUser()->getPerson();
        $p->setValidatedAt(time());
        $p->save();
        
        $this->getUser()->setFlash('success', 'Congratulations ' . $this->getUser()->getPerson() . ', you\'re on!');
        $this->redirect('@logout');
    }
    
    /**
     * Create their profile
     */
    public function executeCreate(sfWebRequest $request) {
        $this->forward404If($this->getUser()->isAuthenticated(), 'Woops! You are already logged in.');
        $r = $this->processForm();
        
        if ($r instanceof Person) {
            $hash = $r->createHash();
            $msg = new PersonValidationMessage($hash);
            $this->getMailer()->send($msg);
            
            $this->getUser()->setFlash('success', 'Almost there! Just check your email address and click the validation link.');
            $this->redirect('@homepage');
        } else {
            $this->form = $r;
        }
        
        $this->setTemplate('create');
    }
    
    /**
     * Display the form to create their profile
     */
    public function executeEdit(sfWebRequest $request) {
        $this->form = $this->processForm($this->getUser()->getPerson());
        $this->setTemplate('create');
    }
    
    /**
     * Save the changes to their profile and log out if successful
     */
    public function executeSave(sfWebRequest $request) {
        $r = $this->processForm($this->getUser()->getPerson());
        if ($r instanceof Person) {
            
            // Cute success message
			$this->getUser()->setFlash('success', 'How about we double check your work?');
			
			$this->person = $r;
			$this->setTemplate('check');
        } else {
            $this->form = $r;
			$this->setTemplate('create');
        }
    }
    
    /**
     * Create and save (if necessary) a PersonForm based on a $person
     *
     * @param Person $person optional
     * @return PersonForm|Person
     */
    protected function processForm(Person $person = null) {
        $request = $this->getRequest();
        
        $form = new PersonForm($person);
        
        if (in_array($request->getMethod(), array('PUT', 'POST'))) {
            $form->bind($request->getParameter($form->getName()),
                        $request->getFiles($form->getName()));
            
            if ($form->isValid()) {
                return $form->save();
            }
        }
        
        return $form;
    }
    
    /**
     * List-based methods follow
     */
    public function executeList(sfWebRequest $request) {
        $this->renderList($request);
    }
    
    public function executeListByCategory(sfWebRequest $request) {
        $this->category = $this->getRoute()->getObject();
        
        $c = new Criteria();
        $c->addJoin(PersonPeer::ID, PersonCategoryPeer::PERSON_ID);
        $c->add(PersonCategoryPeer::CATEGORY_ID, $this->category->getId());
        
        $this->renderList($request, $c);
    }
    
    public function renderList(sfWebRequest $request, Criteria $c = null) {
        $this->per_page = 15;
        
        $this->page = $request->getParameter('page', 1);
        
        $this->people = PersonPeer::getActiveByPage($this->page, $this->per_page, $c);
        
        
        $counts = PersonPeer::countActive($c);
        
        // Calculate the number of photos displayed on previous pages
        $prev_person_count = ($this->page - 1) * $this->per_page;
        
        // If we've displayed less than the total photos
        if ($prev_person_count + count($this->people) < $counts) {
            $this->multiple_pages = true;
        } else {
            $this->multiple_pages = false;
        }
        
        // Serve the JavaScript version if we need to
        if ($request->isXmlHttpRequest()) {
            $this->setTemplate('listJS');            
        } else {
            $this->setTemplate('list');
        }

    }
}