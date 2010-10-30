<?php
class personActions extends sfActions {
    
    public function executeNew(sfWebRequest $request) {
        $this->form = new PersonForm();
        $this->form->setDefault('website', 'http://');
    }
    
    public function executeCreate(sfWebRequest $request) {
        $this->form = new PersonForm();
        $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
        
        if ($this->form->isValid()) {
            $person = $this->form->save();
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