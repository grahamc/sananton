<?php
abstract class myActions extends sfActions {
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