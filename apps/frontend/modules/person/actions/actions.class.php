<?php
class personActions extends myActions {
    /**
     * Validate the person
     */
    public function executeValidate(sfWebRequest $request) {
        $this->hash = $this->getRoute()->getObject();
        $this->forward404If($this->hash->isUsed(), 'Your link has been used, sorry.');
        
        $p = $this->hash->getPerson();
        $p->setValidatedAt(time());
        $p->save();
        $this->hash->makeUsed();
        
        $this->getUser()->setFlash('success', 'Congratulations, ' . $this->hash->getPerson() . '! You\'re on!');
        $this->redirect('@homepage');
    }
    
    public function executeRequestEdit(sfWebRequest $request) {
        if ($request->hasParameter('email')) {
            $email = $request->getParameter('email');
            $person = PersonPeer::getByEmail($email);
            $this->forward404Unless($person instanceof Person, 'No such email address, sorry.');
        
            $hash = $person->createHash();
        
            $msg = new PersonEditMessage($hash);
            $this->getMailer()->send($msg);
            
            $this->getUser()->setFlash('success', 'Almost there! Just check your email address and click the edit link.');
            $this->redirect('@homepage');
        }
    }
    
    /**
     * Edit actions
     */
    public function executeNew(sfWebRequest $request) {
        $this->form = new PersonForm();
        $this->form->setDefault('website', 'http://');
    }
    
    public function executeCreate(sfWebRequest $request) {
        $this->form = new PersonForm();
        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
        
        if ($this->form->isValid()) {
            $person = $this->form->save();
            
            $hash = $person->createHash();
            $msg = new PersonValidationMessage($hash);
            $this->getMailer()->send($msg);
            
            $this->getUser()->setFlash('success', 'Almost there! Just check your email address and click the validation link.');
            $this->redirect('@homepage');
        }
        
        $this->setTemplate('new');
    }
    
    public function executeEdit(sfWebRequest $request) {
        $this->hash = $this->getRoute()->getObject();
        $this->forward404Unless($this->hash->isValid(), 'Your edit link has expired, sorry.');
        
        $this->form = new PersonForm($this->hash->getPerson());
        $this->setTemplate('new');
    }
    
    public function executeSave(sfWebRequest $request) {
        $this->hash = $this->getRoute()->getObject();
        $this->forward404Unless($this->hash->isValid(), 'Your edit link has expired, sorry.');
        
        $this->form = new PersonForm($this->hash->getPerson());
        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
        
        if ($this->form->isValid()) {
            $person = $this->form->save();
            $this->hash->makeUsed();
            $this->redirect('@homepage');
        }
        
        $this->setTemplate('new');
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
        
		$category_name = $this->category->getName(); 

        $this->renderList($request, $c, $category_name);
    }
    

    public function renderList(sfWebRequest $request, Criteria $c = null, $category = null) {
		/** if the category is not null, we modify the response object and change the page title **/
		
		if(!is_null($category)) {
			$response = $this->getResponse(); 
			$response->setTitle($category . 's in San Antonio, Texas'); 
		}
		

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