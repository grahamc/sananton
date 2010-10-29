<?php
class personActions extends sfActions {
    public function executeList(sfWebRequest $request) {
        $this->people = PersonPeer::getActive();
    }
}