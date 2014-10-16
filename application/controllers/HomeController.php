<?php


class HomeController extends Controller {

    /**
     * Construct this object by extending the basic Controller class
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Handles what happens when user moves to URL/index/index, which is the same like URL/index or in this
     * case even URL (without any controller/action) as this is the default controller-action when user gives no input.
     */
    function index()
    {
        $db = new PDO(DBTYPE);
        d($db->query('SELECT * FROM Pattern;')->fetchAll());
        $this->view->render('index/index');
    }
}

