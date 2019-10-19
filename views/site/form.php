<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$f=ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);
echo $email.' - '.$name;
echo $f->field($form,'name');
echo $f->field($form,'email');
echo $f->field($form,'file')->fileInput();
echo Html::submitButton('Отправить');

ActiveForm::end();
