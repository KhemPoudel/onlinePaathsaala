<?php
namespace backend\controllers;
use app\models\faculty\FacultyRecord;
use Yii;
use app\models\contents\ContentsRecord;
use yii\web\Controller;

Class ContentsController extends Controller{
public function actionIndex()
{
    return $this->render('index');
}
    public function actionChoose()
    {
        $model = new ContentsRecord();
        return $this->render('choose',[
        'model'=>$model,

        ]);
    }
   public function actionLists($id)
    {
     $count=FacultyRecord::find()
      ->where(['university_id'=>$id])->count();
        $faculties=FacultyRecord::find()
            ->where(['university_id'=>$id])
            ->all();
        if($count>0)
        {
            foreach($faculties as $faculty)
            {
                echo "<option value='".$faculty->id."'>".$faculty->name."</option>";
            }
        }
        else
        {
            echo "<option>-</option>";
        }
    }
}
?>