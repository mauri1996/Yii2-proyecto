<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord; // manejar la DB

class Alumnos extends ActiveRecord{
    
    public static function getDb() // trae configuracion de la db
    {
        return Yii::$app->db;
    }
    
    public static function tableName() // agrega nombre de la tabla en la DB
    {
        return 'alumnos';
    }
    
}
