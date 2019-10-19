<?php


namespace app\models;


use yii\base\Model;

class MyForm extends Model
{
    public $name;
    public $email;
    public $file;
    public function rules(){
        return [
            [['name','email'],'required'],
            ['email','email','message'=>'Некорректный e-mail'],
            [['file'],'file','extensions'=>'jpg, png']
        ];
    }
}