<?php
class personActions extends sfActions {
    protected $per_page = 1;
    
    
    public function executeList(sfWebRequest $request) {
        $this->renderList($request);
    }
    
    public function renderList(sfWebRequest $request, Criteria $c = null) {
        $page = $request->getParameter('page', 1);
        
        $this->people = PersonPeer::getActiveByPage($page, $this->per_page, $c);
        
        $counts = PersonPeer::countActive($c);
        
        // Calculate the number of photos displayed on previous pages
        $prev_person_count = ($page - 1) * $this->per_page;
        
        // If we've displayed less than the total photos
        if ($prev_person_count + count($this->people) < $counts) {
            $this->multiple_pages = true;
        } else {
            $this->multiple_pages = false;
        }
        
        $this->setTemplate('list');
    }
}