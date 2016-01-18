<?php
use yii\helpers\Html;
use frontend\controllers\TopicController;
?>
<div class="search-class">
<pre class="language-markup">
    <code class="language-markup" style="margin-top: -7%;">
        <div class="text-center" style="font-weight: bolder;">
            <span>University:<?=$university?></span>
            <span>Faculty:<?=$faculty?></span>
            <span>Program:<?=$program?></span>
            <span>Course:<?=$course?></span>
        </div>
        <?php
        $j=1;
        foreach($model as $m)
        {
            if($m->parent_id==null)
            {
                echo '<br><span class="token attr-value">'.$j.')</span>';
                $j++;
                echo $this->context->renderChild($m);
            }
        }
        ?>
    </code>
</pre>
</div>
