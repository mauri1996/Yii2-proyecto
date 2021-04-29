<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ValidarFormulario; // agregar el nuevo modelo creado

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

    /**
     * Displays hola page.
     *
     * @return string
     */
    public function actionHola()
    {
        return $this->render('hola');
    }

    public function actionSaluda($get = 'hola desde parametro')
    {
        $mensaje = "hola mundo";
        $numeros= [1,2,3,4,5];
        return $this->render('saluda',
            [
                'mensajes' => $mensaje,
                'arreglo' => $numeros,
                'get' => $get
            ]
        );
        
    }

    /// accion no ligada a uan vista, solo procesa informacion
    public function actionRequest(){
        $mensaje=null;
        if(isset($_REQUEST["nombre"])){ // si existe la variablle 
            $mensaje = "Has enviado tu nombre correctamente: ".$_REQUEST["nombre"];
            //$name = $_REQUEST["nombre"];

        }

        $this->redirect([
                            "site/formulario", 
                            "mensaje" => $mensaje
                            //"nombre" => $name
                        ] 
            );
    }

    public function actionValidarformulario(){
        $model = new ValidarFormulario();
        if($model->load(Yii::$app->request->post())){  // si enviamos el formulario
            if($model->validate()){ // si el formulario es valido

                //Consultar base de datos, a que los datos han sido correctos.
                // o mostrar errores
            }else{
                $model->getErrors();
            }
        }

        return $this->render('validarformulario',['model'=>$model]);
    }

    public function actionFormulario($mensaje = null){
        return $this->render('formulario',['mensaje' => $mensaje]);
    }

}
