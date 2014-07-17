<?php
Yii::import('bootstrap.widgets.input.TbInputHorizontal0');
class TbInputHorizontal extends TbInputHorizontal0{
  /**
	 * Renders a file field.
	 * @return string the rendered content
	 */
	protected function fileField()
	{
    $remover = "<a onclick='removeFile(\"#\",\"".CHtml::activeId($this->model, $this->attribute)."\")' href='#'><i class='icon-remove'></i> Remove</a>";
    echo $this->getLabel();
		echo '<div class="controls">';
    echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions).'<span id="'.CHtml::activeId($this->model, $this->attribute).'-remove">'.$remover.'</span>';
    echo '<br/>';  
    echo '<span id="'.CHtml::activeId($this->model, $this->attribute).'-cum-uploader" class="uploadify"></span>';
		echo $this->getError().$this->getHint();
		echo '</div>';
	}
} 
?>