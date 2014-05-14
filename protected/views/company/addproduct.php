<h2>Add a <?php echo $category?></h2>

<?php echo $this->renderPartial($category.'/create', array('model'=>$model,'image'=>$image)); ?>