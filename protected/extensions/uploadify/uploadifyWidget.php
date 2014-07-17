<?php
class uploadifyWidget extends CInputWidget {
    public $model;
    public $attribute; 
    public $form;
   
    public function run() {
        $controller=$this->controller;
        $action=$controller->action;
        $this->render('uploadifyWidget',array(
          'model'=>$this->model,
          'attribute'=>$this->attribute,
          'form'=>$this->form
        ));
    }
}