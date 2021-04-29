<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ValidarFormulario extends Model{
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
            ['email','email','message'=> 'Formato no valido']
        ];
    }

    // poder cambiar etiquetas label de cada campo
    public function attributeLabels(){
        return [
            'nombre' => 'Nombre: ',
            'email' => 'Email: '
        ];
    }

}