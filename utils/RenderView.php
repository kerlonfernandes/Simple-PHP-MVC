<?php


class RenderView {

    public function view($view, $args): void {

        extract(array: $args);

            require_once __DIR__."/../public/views/$view.php";

        }

    } 

