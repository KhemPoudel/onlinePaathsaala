<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;



?>
<?php $form = ActiveForm::begin(); ?>
   <?= $form->field($model,'university')->dropDownList
(ArrayHelper::map(app\models\university\UniversityRecord::find()->all(),'id','name'),
    [
        'prompt'=>'select university',
        'onchange'=>'
        $.post("index.php?r=contents/lists&id='.'"+$(this).val(),function(data)
        {
        $("select#contentsrecord-faculty").html(data);
        });'

    ]);?>
<?= $form->field($model,'faculty')->dropDownList
(ArrayHelper::map(app\models\faculty\FacultyRecord::find()->all(),'id','name'),
    [
        'prompt'=>'select branch',

    ]);?>

<?php $form= ActiveForm::end(); ?>