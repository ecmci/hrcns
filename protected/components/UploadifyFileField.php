<?php
Yii::import('ext.yii-bootstrap.widgets.input.TbInputHorizontal');
class UploadifyFileField extends TbInputHorizontal{
  	public $model, $attribute, $htmlOptions;
    public function fileField()
  	{
  		echo $this->getLabel();
  		echo '<div class="controls">';
  		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
  		echo $this->getError().$this->getHint();
  		echo '</div>';
  	}
    
    private function getLabel()
  	{
  		if (isset($this->labelOptions['class']))
  			$this->labelOptions['class'] .= ' control-label';
  		else
  			$this->labelOptions['class'] = 'control-label';
  
  		return parent::getLabel();
  	}  
}
?>