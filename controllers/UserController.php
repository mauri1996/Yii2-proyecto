<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\cliente\FormOlvidePassword;
use app\models\Users;

class UserController extends Controller{
    

    public function actionForgotpassword(){                        

        $form= new FormOlvidePassword();        
        if ($form->load(Yii::$app->request->post())) { // si el fomulario es enviado
            if($form->validate()){
                
                $user = Users::find()
                        ->where("email=:email",[':email'=>$form->email])
                        ->one();
                if($user){

                    $id = urlencode($user->id);
                    $authKey = urlencode($user->authKey);

                    $subject = "Recuperar contraseña";
                    $body = "<h1>Haga click en el siguiente enlace para cambiar tu contraseña</h1>";
                    $body .= "<a href='http://localhost:8080/index.php?r=site/resetpassword&id=" . $id . "&authKey=" . $authKey . "'>Confirmar</a>";

                    //Enviamos el correo
                    Yii::$app->mailer->compose()
                        ->setTo($user->email)
                        ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                        ->setSubject($subject)
                        ->setHtmlBody($body)
                        ->send();

                    $form->email = null;
                    $msg = 'Se ha enviado al correo el link para cambiar la contraseña';

                }else{
                    $msg = 'No se encontro un usuario con ese correo';
                }


            }else{
                $form->getErrors();
            }            
            return $this->render('olvidecontrasena',['model'=>$form,'msg'=>$msg]);   
        }

        if (Yii::$app->request->get()) {
            $model = new FormOlvidePassword();
            $model->email = null;
            $msg = null;
            return $this->render('olvidecontrasena',['model'=>$model,'msg'=>$msg]);            
        }


    }

}