<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#"><?php echo Yii::app()->name; ?></a>
            <div class="nav-collapse collapse">
                <?php
                	$this->widget('zii.widgets.CMenu',array(
                    	'htmlOptions'=>array('class'=>'nav pull-right'),
                    	'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
							        //'itemCssClass'=>'item-test',
                    	'encodeLabel'=>false,
                    	'items'=>Navigation::getMenuItems()
                )); 
                ?>
                <?php /* >
                <form class="navbar-form pull-right">
                    <input class="span2" type="text" placeholder="Email">
                    <input class="span2" type="password" placeholder="Password">
                    <button type="submit" class="btn">Sign in</button>
                </form>
                */ ?>                
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>