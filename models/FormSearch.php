<?php

namespace app\models;
use Yii;
use yii\base\Model;

class FormSearch extends Model{
    public $q;

    public function rules()
    {
        return [
            ['q','match','pattern'=>"/^[0-9a-zñ\s]+$/i",'message'=>'Solo se aceptan lentras y numeros']
        ];
    }

    public function attributeLabels()
    {
        return [
            'q' => 'Buscar'
        ];
    }   
}
