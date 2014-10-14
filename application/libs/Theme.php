<?php


class Theme {
    public $title, $author, $id;

    function __construct($id, $title = '', $author = ''){
        $this -> id = (int) $id;
        $this -> title = $title;
        $this -> author = $author;
    }
}