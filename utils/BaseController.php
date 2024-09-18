<?php

use HelpersClass\Helpers;
require './classes/Helpers.class.php';
require './classes/Operations.class.php'; 

class BaseController extends RenderView
{
    public Helpers $helpers;
    public Operations $operations;

    public function __construct() {
        $this->helpers = new Helpers(); // Instancia a classe Helpers
        $this->operations = new Operations(); // Instancia a classe Operations
    }
}
