<?php

namespace app\controllers;
use app\models\Comments;
use yii\data\Pagination;
use yii\helpers\Html;
use app\models\MyForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionForm(){
        $form=new MyForm();
        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $name=Html::encode($form->name);
            $email=Html::encode($form->email);
            $form->file=UploadedFile::getInstance($form,'file');
            $form->file->saveAs('photo/'.$form->file->baseName.'.'.$form->file->extension);
        }else{

            $name='';
            $email='';
        }
        return $this->render('form',['form'=>$form,'name'=>$name,'email'=>$email]);
    }
    public  function actionComments(){
        $comments=Comments::find();
        $pagination = new Pagination([
            'defaultPageSize'=>2,
            'totalCount'=>$comments->count()
        ]);
        $comments=$comments
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render(
            'comments',
            ['comments'=>$comments,'pagination'=>$pagination]
        );
    }
    public function actionUser(){
        $user=Yii::$app->request->get('name');
        return $this->render('user',['user'=>$user]);
    }
}
