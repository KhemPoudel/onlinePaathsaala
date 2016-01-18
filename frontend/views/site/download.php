<?php
if (file_exists($file)) {
    Yii::$app->response->sendFile($file);
}
?>