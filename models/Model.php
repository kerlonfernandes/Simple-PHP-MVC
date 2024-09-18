<?php
use Midspace\Database;

require_once("./classes/Operations.php");

class Model extends Operations{

    private string $table;
    public function __construct(string $table) {
        parent::__construct();
    }
    
    public function get() {

        return $this->select("*", $this->table);

    }
    
}   