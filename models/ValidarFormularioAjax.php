<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ValidarFormularioAjax extends Model{
    public $nombre;  //atributos de la vista
    public $email;

    // parametros de validacion para los atributos
    public function rules()
    {
        return [ // el 3 parametro saldra como error debajo del imput 
            ['nombre', 'required','message'=>'Campo requerido'],
            ['nombre', 'match' , 'pattern' => "/^.{3,50}$/","message"=>'Minimo 3 y maximo 5 caracteres'],
            ['nombre', 'match' , 'pattern' => "/^[0-9a-z]+$/i", "message" => "Solo se aceptan letras y numeros"],
            ['email', 'required', 'message' =>'Campo requerido'],
            ['email', 'match' , 'pattern' => "/^.{5,80}$/","message"=>'minimo 5 y maximo 80 caracteres'],
            ['email','email','message'=> 'Formato no valido'],
            ['email', 'email_existe'] // valida con una funcion
        ];
    }

    // poder cambiar etiquetas label de cada campo
    public function attributeLabels(){
        return [
            'nombre' => 'Nombre: ',
            'email' => 'Email: '
        ];
    }

    public function email_existe($attribute,$params){
        $emails = ['mc@mail.com','aaa@mail.com'];  // vtrae los email de db

        foreach ($emails as $email){
            if($this->email == $email){
                $this->addError($attribute,"El email seleccionado existe");
                return true;
            }
        }
        return false;

    }

}