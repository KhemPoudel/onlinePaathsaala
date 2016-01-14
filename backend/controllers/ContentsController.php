<?php
namespace backend\controllers;
use Yii;
use yii\base\Controller;
use\yii\db\ActiveRecord;

Class ContentsController extends Controller{
public function actionIndex()
{
    return $this->render('index');
}
    public function actionChoose()
    {
        return $this->render('choose');
    }
}
?>