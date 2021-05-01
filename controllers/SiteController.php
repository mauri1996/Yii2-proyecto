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
use app\models\ValidarFormularioAjax; // agregar el nuevo modelo creadocon ajax

// para trabajr con ajax
 use yii\widgets\ActiveForm;
 //use yii\web\response; ya esta importdo

 //trabajar con conexion a la db
use app\models\Alumnos;
use app\models\FormAlumnos;

// buscar

use app\models\FormSearch;
use yii\helpers\Html; // usa enconde para prevenir ataques

use yii\data\Pagination; // para paginacion

use yii\helpers\Url; // para url delete

class SiteController extends Controller
{
    public function actionCreate(){
        $model = new FormAlumnos();
        $msg = null;

        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                
                $table = new Alumnos();
                $table->nombre = $model->nombre;
                $table->apellidos = $model->apellidos;
                $table->clase = $model->clase;
                $table->nota_final = $model->nota_final;
                
                if($table->insert()){
                    $msg= 'Resgistro insertados correctamente';
                    $model->nombre = null;
                    $model->apellidos = null;
                    $model->clase = null;
                    $model->nota_final = null;
                }else{
                    $msg= 'Ha aocurrido un error al insertar el registro';
                }

            }else{
                $model->getErrors();
            }
        }

        return $this->render('create', [
                                        'model'=>$model,
                                        'msg'=>$msg 
                                        ]);
    }

    public function actionView(){
        // ANTES DE LA PAGINACION
        // $table = new Alumnos();
        // $model = $table->find()->all();
        // //$model = Alumnos::find()->all(); // todos lso registros de la tabla alumnos

        // $form = new FormSearch();
        // $search =null;

        // if($form->load(Yii::$app->request->post())){
        //     if($form->validate()){
        //         $search = Html::encode($form->q); // previene ataques
        //         $querry = "SELECT * FROM alumnos where id_alumno LIKE '%$search%' OR ";
        //         $querry.="nombre LIKE '%$search%' OR apellidos LIKE '%$search%'";

        //         $model = $table->findBySql($querry)->all();
        //     }else{
        //         $form->getErrors();
        //     }
        // }

        $form = new FormSearch();
        $search=null;
        if($form->load(Yii::$app->request->post())){ // si el fomulario es enviado            
            if($form->validate()){
                $search = Html::encode($form->q); // hace q lo q s emande por el imput sea solo texto
                $table = Alumnos::find()
                            ->where(['like',"id_alumno",$search])
                            ->orWhere(['like','nombre',$search])
                            ->orWhere(['like','apellidos',$search]);
                $count = clone $table; // clona la tabla
                $pages =  new Pagination([   //parametros de la paginacion
                        'pageSize' =>1,
                        'totalCount'=>$count->count()
                ]);
                // generacion del modelo con la paginacion y los limites
                $model = $table
                            ->offset($pages->offset)
                            ->limit($pages->limit)
                            ->all();
            }else{
                $form->getErrors();
            }
        }else{            
            $table = Alumnos::find();
            $count = clone $table;

            $pages = new Pagination([
                'pageSize'=>1,
                'totalCount' => $count->count()
            ]);
            $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
        }

        //return $this->render('view',['model'=>$model,'form' => $form , 'search' =>$search]);
        return $this->render('view',['model'=>$model,'form' => $form , 'search' =>$search, 'pages'=>$pages]);
    }

    public function actionDelete(){

        if(Yii::$app->request->post()){

            $id_almuno = Html::encode($_POST['id_alumno']);
            if((int)$id_almuno){

                if(Alumnos::deleteAll("id_alumno=:id_alumno",[":id_alumno"=>$id_almuno])){
                    echo "Alumno con id=".$id_almuno." eliminado con exito, redireccionando....";
                    echo "<meta http-equiv='refresh' content='3;".Url::toRoute('site/view')."'>"; // devuelve al view si todo sale bn esperando 3 sg
                }else{
                    echo "Ha ocurrido un error al eliminar al alumno redireccionando....";
                    echo "<meta http-equiv='refresh' content='3;".Url::toRoute('site/view')."'>"; // devuelve al view si no es entero id_alumno    
                }

            }else{
                echo "Ha ocurrido un error al eliminar al alumno redireccionando....";
                echo "<meta http-equiv='refresh' content='3;".Url::toRoute('site/view')."'>"; // devuelve al view si no es entero id_alumno
            }

        }else{

            return $this->redirect(['site/delete']);
        }
        
    }
    public function actionUpdate(){

        $model = new FormAlumnos(); // simepre
        $msg = null;


        ///////// SI SE ENVIA UN POST

        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                
                $table = Alumnos::findOne($model->id_alumno);

                if($table){

                    $table->nombre = $model->nombre;
                    $table->apellidos = $model->apellidos;
                    $table->clase = $model->clase;
                    $table->nota_final = $model->nota_final;

                    if($table->update()){ // Actualizar un registro

                        $msg= 'El alumno ha sido actualizado correctamente';
                        $model->nombre = null;
                        $model->apellidos = null;
                        $model->clase = null;
                        $model->nota_final = null;
                    }else{
                        $msg= 'Ha aocurrido un error al actualizar el registro';
                    }

                }else{
                    $msg = "El alumno no ha sido encontrado";
                }                

            }else{
                $model->getErrors();
            }
        }


        ///////// SI SE ENVIA UN GET

        if(Yii::$app->request->get('id_alumno')){ // si el parametro id_alumno es enviado

            $id_alumno = Html::encode($_GET['id_alumno']);

            if((int)$id_alumno){ // si es un numero entero

                $table = Alumnos::findOne($id_alumno); // busca el primer elemento con esa id                                
                
                if($table){

                    $model->id_alumno = $table->id_alumno;
                    $model->nombre = $table->nombre;
                    $model->apellidos = $table->apellidos;
                    $model->clase = $table->clase;
                    $model->nota_final = $table->nota_final;
                    $name = $table->nombre.' '.$table->apellidos;

                }else{
                    return $this->redirect(['site/view']); 
                }

            }else{
                return $this->redirect(['site/view']);    
            }
            
        }else{            
            return $this->redirect(['site/view']);
        }

        return $this->render('update',['model'=>$model, 'msg' =>$msg, 'name'=> $name]);
    }
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
            Yii::$app->session->setFlash('contactFormSubmitted'); // crea clave Flash

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

    public function actionValidarformularioajax(){
        $model = new ValidarFormularioAjax();
        $msg = null;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){ // verificia si se envia post y si es ajax
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);            
        }

        if ($model->load(Yii::$app->request->post())){ // verificia si se envia post
            if($model->validate()){
                //
                $msg = "Formulario enviado correctamente";
                // borrar campos
                $model->nombre = null;
                $model ->email = null;
            }else{
                $model->getErrors();
            }            
        }

        return $this->render('validarformularioajax',['model' => $model, 'msg'=>$msg]);
    }

}
