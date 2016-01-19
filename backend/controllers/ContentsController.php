<?php
namespace backend\controllers;

use app\models\content\ContentRecord;
use app\models\program\ProgramRecord;
use app\models\university\UniversityRecord;
use common\models\course\CourseRecord;
use common\models\topic\TopicRecord;
use Yii;
use app\models\contents\ContentsRecord;
use app\models\faculty\FacultyRecord;
use yii\helpers\Json;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

Class ContentsController extends Controller{

    public $topic_id;
    public function actionOption()
    {
        $model = new ContentsRecord();
$university=ArrayHelper::map(UniversityRecord::find()->all(),'id','name');
        return $this->render('option',[
            'model'=>$model,
            'university'=>$university,
        ]);
    }
    public function progs($id)
    {
return ArrayHelper::map(FacultyRecord::find()->where(['university_id'=>$id])
    ->select(['id','name'])->asArray()->all(),'id','name');
    }
    public function actionProgram()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null)
            {
                $id = $parents[0];
                $out = self::progs($id);
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);

    }

public function actionIndex()
{
    return $this->render('index');
}

    public function actionChoose($label)
    {
        $model = new ContentsRecord();
        if ($model->load(Yii::$app->request->post()))
        {

            $imageName=$model->name;
            //get the instance of uploaded file

            $model->$label=UploadedFile::getInstance($model,$label);
            $model->$label->saveAs('uploads/'.$imageName.'.'.$model->$label->extension);
// save the path in db
            $db=new ContentRecord();

            $db->name=$imageName;
            $db->address='uploads/'.$imageName.'.'.$model->$label->extension;
            $db->save();
        }
        else {
            return $this->render('choose', [
                'model' => $model,
                'label' => $label,

            ]);
        }
    }
   public function actionLists($id)
    {
        $first=1;
     $count=FacultyRecord::find()
      ->where(['university_id'=>$id])->count();
        $faculties=FacultyRecord::find()
            ->where(['university_id'=>$id])
            ->all();
        if($count>0)
        {
            echo "<option value='".$first."'>".'select'."</option>";
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
    public function actionPrograms($id)
    {
        $first=1;
        $count=ProgramRecord::find()
            ->where(['faculty_id'=>$id])->count();
        $programs=ProgramRecord::find()
            ->where(['faculty_id'=>$id])
            ->all();
        if($count>0)
        {
            echo "<option value='".$first."'>".'select'."</option>";
            foreach($programs as $program)
            {
                echo "<option value='".$program->id."'>".$program->name."</option>";
            }
        }
        else
        {
            echo "<option>-</option>";
        }
    }
    public function actionCourses($id)
    {
        $first=1;
        $count=CourseRecord::find()
            ->where(['program_id'=>$id])->count();
        $courses=CourseRecord::find()
            ->where(['program_id'=>$id])
            ->all();
        if($count>0)
        {
            echo "<option value='".$first."'>".'select'."</option>";
            foreach($courses as $course)
            {
                echo "<option data-toggle='modal' data-target='#myModal' value='".$course->id."'>".$course->name."</option>";
            }
        }
        else
        {
            echo "<option>-</option>";
        }
    }
    public function actionTopics($id)
    {
        $first=1;
        $count=TopicRecord::find()
            ->where(['course_id'=>$id])->count();
        $topics=TopicRecord::find()
            ->where(['course_id'=>$id])
            ->all();
        if($count>0)
        {
            echo "<option value='".$first."'>".'select'."</option>";
            foreach($topics as $topic)
            {
                echo "<option  value='".$topic->id."'>".$topic->name."</option>";
            }
        }
        else
        {
            echo "<option>-</option>";
        }
    }
    public function actionSubmits($id)
    {
echo "<?= $"."form->field($"."model, 'topic_id')->textInput(['maxlength' => true,'value'=>".$id."]) ?>";
    }

public function actionStore()
{
return $this->render('index');
}

}
?>