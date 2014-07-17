                                       
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?Yii::app()->baseUrl; ?>"><?php echo Yii::app()->name; ?></a>
            <div class="nav-collapse collapse">            
            <?php $this->widget('bootstrap.widgets.TbNavbar',array(
                'items'=>array(
                    array(
                        'class'=>'bootstrap.widgets.TbMenu',
                        'htmlOptions'=>array('class'=>'nav pull-right'),
                        'items'=>Navigation::getMenuItems(),
                        'encodeLabel'=>false,
                    ),
                ),
            )); ?>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>