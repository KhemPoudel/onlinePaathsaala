<?php \yii\widgets\Pjax::begin(['id' =>'like-group']);?>
<form>
    <div class="input-group">
        <div class="input-group-btn">
                <?php $like_status=$this->context->IflikedByUser($model); ?>
                <?= \yii\bootstrap\Html::a($this->context->getDislikes($model).
                "<i class='glyphicon glyphicon-thumbs-down' ></i>", ['update','like_status'=>$like_status,'present_status'=>0,'id'=>$model->id], ['class' => 'btn btn-default']) ?>
            <button class="btn btn-default" id="btn-like">
                <?php echo $this->context->getDislikes($model);
                echo Yii::$app->request->baseUrl;?>
                <i class="glyphicon glyphicon-thumbs-up"></i>
            </button>
            <button class="btn btn-default">
                <i class="glyphicon glyphicon-share"></i>
            </button>
        </div>
    </div>
</form>
<?php \yii\widgets\Pjax::end();?>
<?php
$js = <<<JS
        // get the form id and set the event
        $('#btn-like').on('click', function(e) {
        e.preventDefault();
            $.ajax({
                url:'?r=site/update',
                type: 'post',
                data:
                {
                    'like_status':'<?php echo $like_status;?>',
                    'present_status':1,
                    'id':'<?php echo $model->id;?>'
                },
                success: function(response) {
                //alert('ssdasd');
                var csrf = yii.getCsrfToken();
                    var url = '?r=site/update'+ '&_csrf='+csrf;
                    $.pjax.reload({url: url, container:'#like-group'});

                }
            });
        });

JS;
$this->registerJs($js);
?>