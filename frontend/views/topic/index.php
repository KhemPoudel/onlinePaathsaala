<?php
use yii\helpers\Html;
use frontend\controllers\TopicController;
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <p>
            <h4>Syllabus</h4>
            </p>
                <span style="">
                </span>
        </div>
        <div class="panel-body" style="">
            <div style="border-bottom: groove">
                <h4><strong>University:</strong><?= $university;?></h4>
                <h5><strong>Faculty:</strong><?= $faculty;?></h5>
                <h5><strong>Program:</strong><?= $program;?></h5>
                <h5><strong>Course:</strong><?= $course;?></h5>
            </div>

            <div style="">
                <?php
                $j=1;
                foreach($model as $m)
                {
                    if($m->parent_id==null)
                    {
                        echo $j.')';
                        $j++;
                        echo $this->context->renderChild($m);
                    }
                }
                //print_r($model_array);

                ?>
            </div>

        </div>
    </div>