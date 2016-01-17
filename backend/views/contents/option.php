<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model,'university')->dropDownList($university,['id'=>'university']);?>
 <?= $form->field($model, 'faculty')->widget(DepDrop::classname(), [
    'options'=>['id'=>'faculty-id'],
    'pluginOptions'=>[
    'depends'=>['university'],
    'placeholder'=>'Select...',
    'url'=>\yii\helpers\Url::to(['contents/program'])
    ]
    ])?>

<?php $form= ActiveForm::end(); ?>