<?php

namespace app\models\cliente;

use Yii;
use yii\base\Model;

class FormOlvidePassword extends Model
{    
    public $email;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres'],
            ['email', 'email', 'message' => 'Formato no válido'],
        ];
    }    



   
}
