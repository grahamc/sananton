<?php
class personActions extends sfActions {
    public function executeList(sfWebRequest $request) {
        $this->people = array('foo', 'bar', 'baz');
    }
}