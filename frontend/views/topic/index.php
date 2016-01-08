<?php
use yii\helpers\Html;
use frontend\controllers\TopicController;

foreach($model as $m)
{
  if($m->parent_id==null)
  {
      echo $this->context->renderChild($m);
  }
}

?>