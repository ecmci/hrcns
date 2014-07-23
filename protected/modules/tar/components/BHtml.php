<?php
class BHtml{
  public static function dropDownList($model,$attribute,$data,$options=array(),$form){
    $tpl = '<div class="control-group">';
    $tpl .= $form->labelEx($model,$attribute,array('class'=>'control-label'));
      $tpl .= '<div class="controls">'; 
        $tpl .= $form->dropDownList($model,$attribute,$data,$options);
        $tpl .= $form->error($model,$attribute);  
      $tpl .= '</div>';
    $tpl .= '</div>';    
    return $tpl;
  }
  
  public static function textField($model,$attribute,$options=array(),$form){
    $tpl = '<div class="control-group">';
    $tpl .= $form->labelEx($model,$attribute,array('class'=>'control-label'));
      $tpl .= '<div class="controls">'; 
        $tpl .= $form->textField($model,$attribute,$options);
        $tpl .= $form->error($model,$attribute);  
      $tpl .= '</div>';
    $tpl .= '</div>';    
    return $tpl;
  }
  
  public static function textArea($model,$attribute,$options=array(),$form){
    $tpl = '<div class="control-group">';
    $tpl .= $form->labelEx($model,$attribute,array('class'=>'control-label'));
      $tpl .= '<div class="controls">'; 
        $tpl .= $form->textArea($model,$attribute,$options);
        $tpl .= $form->error($model,$attribute);  
      $tpl .= '</div>';
    $tpl .= '</div>';    
    return $tpl;
  }  
} 
?>