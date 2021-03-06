<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;



?>

    <div class="well col-lg-6">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model,'university')->dropDownList
        (ArrayHelper::map(app\models\university\UniversityRecord::find()->all(),'id','name'),
            [
                'prompt'=>'select university',
                'onchange'=>'
        $.post("index.php?r=contents/lists&id='.'"+$(this).val(),function(data)
        {
        $("select#contentrecord-faculty").html(data);
        });'

            ]);?>
        <?= $form->field($model,'faculty')->dropDownList
        (ArrayHelper::map(app\models\faculty\FacultyRecord::find()->all(),'id','name'),
            [
                'prompt'=>'select faculty',
                'onchange'=>'
        $.post("index.php?r=contents/programs&id='.'"+$(this).val(),function(data)
        {
        $("select#contentrecord-program").html(data);
        });'

            ]);?>
        <?= $form->field($model,'program')->dropDownList
        (ArrayHelper::map(app\models\program\ProgramRecord::find()->all(),'id','name'),
            [
                'prompt'=>'select program',
                'onchange'=>'
        $.post("index.php?r=contents/courses&id='.'"+$(this).val(),function(data)
        {
        $("select#contentrecord-course").html(data);
        });'

            ]);?>
        <?= $form->field($model,'course')->dropDownList
        (ArrayHelper::map(app\models\course\CourseRecord::find()->all(),'id','name'),
            [
                'prompt'=>'select course',
                'onchange'=>'
        $.post("index.php?r=contents/topics&id='.'"+$(this).val(),function(data)
        {
        $("select#topic").html(data);
        });'

            ]);?>

        <?= $form->field($model,'topic')->dropDownList
        (ArrayHelper::map(app\models\topic\TopicRecord::find()->all(),'id','name'),
            [
                'prompt'=>'select course','id'=>"topic"


            ]);?>
        <?= $form->field($model, 'topic_id')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?php
        if($label=='image')
        {

            echo $form->field($model, $label)->widget(FileInput::classname(), [
                'options'=>['accept'=>$label.'/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]]);
        }
        elseif($label=='pdf'){

            echo $form->field($model, $label)->widget(FileInput::classname(), [
                'options'=>['accept'=>$label.'/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['pdf']]]);
        }
        elseif($label=='video'){

            echo $form->field($model, $label)->widget(FileInput::classname(), [
                'options'=>['accept'=>$label.'/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['mp4']]]);
        }
        ?>

        <div class="form-group">
            <?= Html::submitButton('save',['create','label'=>$label],['class'=>'btn btn-primary']) ?>
        </div>

        <?php $form= ActiveForm::end(); ?>

        <?= Html::a('back',['/contents/store'],['class'=>'btn btn-primary'])?>
    </div>
<?php
$script = <<<JS
    $('#topic').change(function(){
var topic_id=$(this).val();
$('#contentrecord-topic_id').attr('value',topic_id);
});
JS;
$this->registerJs($script);

?>