<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="dropdown" style="position:relative">
    <a href="#" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Click Here <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li>
            <a class="trigger right-caret">Level 1</a>
            <ul class="dropdown-menu sub-menu">
                <li><a href="#">Level 2</a></li>
                <li>
                    <a class="trigger right-caret">Level 2</a>
                    <ul class="dropdown-menu sub-menu">
                        <li><a href="#">Level 3</a></li>
                        <li><a href="#">Level 3</a></li>
                        <li>
                            <a class="trigger right-caret">Level 3</a>
                            <ul class="dropdown-menu sub-menu">
                                <li><a href="#">Level 4</a></li>
                                <li><a href="#">Level 4</a></li>
                                <li><a href="#">Level 4</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="#">Level 2</a></li>
            </ul>
        </li>
        <li><a href="#">Level 1</a></li>
        <li><a href="#">Level 1</a></li>
    </ul>
</div>