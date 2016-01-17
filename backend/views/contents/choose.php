<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;



?>

<div class="well col-lg-6">
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
        'prompt'=>'select faculty',
        'onchange'=>'
        $.post("index.php?r=contents/programs&id='.'"+$(this).val(),function(data)
        {
        $("select#contentsrecord-program").html(data);
        });'

    ]);?>
<?= $form->field($model,'program')->dropDownList
(ArrayHelper::map(app\models\program\ProgramRecord::find()->all(),'id','name'),
    [
        'prompt'=>'select program',
        'onchange'=>'
        $.post("index.php?r=contents/courses&id='.'"+$(this).val(),function(data)
        {
        $("select#contentsrecord-course").html(data);
        });'

    ]);?>
<?= $form->field($model,'course')->dropDownList
(ArrayHelper::map(app\models\course\CourseRecord::find()->all(),'id','name'),
    [
        'prompt'=>'select course',


    ]);?>
</div>
<?php $form= ActiveForm::end(); ?>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
