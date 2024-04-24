<?php

class Route {
    public $mahasiswa;
    public $matakuliah;
    public $perkuliahan;
    public $main;

    public function __construct() {
        $this->mahasiswa = new TemplateRoute("mahasiswa");
        $this->matakuliah = new TemplateRoute("matakuliah");
        $this->perkuliahan = new TemplateRoute("perkuliahan");
        $this->main = new TemplateRoute("main");
    }
    
}

class TemplateRoute {
    public $name;
    private $do = "_do";
    private $view = "_view";
    private $php = ".php";
    public $index;
    public $insertDo;
    public $insertView;
    public $updateDo;
    private $updateView;
    private $deleteDo;
    
    public function __construct(String $var) {
        $this->name = $var;
        $this->index =      $this->name . "_index" . $this->php; 
        $this->insertDo =   $this->name . "_insert" . $this->do . $this->php;
        $this->insertView = $this->name . "_insert" . $this->view . $this->php;
        $this->updateDo =   $this->name . "_update" . $this->do . $this->php;
        $this->updateView = $this->name . "_update" . $this->view . $this->php;
        $this->deleteDo =   $this->name . "_delete" . $this->do . $this->php;
    }

    public function getUpdateView($params, $value) {
        return $this->updateView . "?". $params ."=" . $value;
    }

    public function getUpdateViewTwoParams($params1, $value1, $params2, $value2) {
        return $this->updateView . "?". $params1 ."=" . $value1 . "&" . $params2 . "=" . $value2;
    }

    public function getDeleteDo($params, $value) {
        return $this->deleteDo . "?". $params ."=" . $value;
    }

    public function getDeleteDoTwoParams($params1, $value1, $params2, $value2) {
        return $this->deleteDo . "?". $params1 ."=" . $value1 . "&" . $params2 . "=" . $value2;
    }


}

?>