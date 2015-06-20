<?php

class MessageController extends Zend_Controller_Action {

    public function init() {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function getAction() {
        $response = $this->getResponse();
        $messenger = Messenger::getInstance();
        $messages = $messenger->getMessages();
        $arr = array(
            "unread" => $messenger->hasUnreadMessages(),
            "messages" => $messages
        );
        $response->appendBody(json_encode($arr));
    }

    public function ackAction() {
        Messenger::getInstance()->ackUnreadMessages();
    }

}