<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(

	  'id'=>'login-form',

    //'type'=>'horizontal',

	  'enableClientValidation'=>true,



)); ?>



	<?php echo $form->textFieldRow($model,'username',array('placeholder'=>'Username','required'=>'required')); ?>

             <p>
           steven.l@evacare.com
          </p>

	<?php echo $form->passwordFieldRow($model,'password',array(

        //'hint'=>'Hint: You may login with username: <kbd>steven.l@evacare.com</kbd> and password: <kbd>steven.l</kbd>',

        'placeholder'=>'Password',

        'required'=>'required'

    )); ?>
    
              <p>
           eva1937
          </p>

	<div class="form-actions">

		

    <?php  $this->widget('bootstrap.widgets.TbButton', array(

            'buttonType'=>'submit',

            'type'=>'primary',

            'size'=>'large',

            'label'=>'Login',

        )); ?>

   

	</div>

<?php $this->endWidget(); ?>



</div><!-- form -->

