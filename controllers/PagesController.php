<?php

class PagesController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function home(): void
    {   

        $this->view("welcome", args: [
            "title" => "Welcome!"
        ]);
    }

}

