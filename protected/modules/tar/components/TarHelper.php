<?php
class TarHelper{
  public static function getFacilityList(){
    return CHtml::listData(Facility::model()->findAll(),'idFACILITY','title');
  }
}
?>