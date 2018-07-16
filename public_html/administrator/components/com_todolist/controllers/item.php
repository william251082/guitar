<?php
defined('_JEXEC') or die;
// For individual tasks such as save and delete

jimport('joomla.application.component.controllerform');

class TodolistControllerItem extends JControllerForm
{
    public function __construct()
    {
        $this->view_list = 'items';
        parent::__construct();
    }
}