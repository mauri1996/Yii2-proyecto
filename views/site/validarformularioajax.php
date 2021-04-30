<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<h1>Validar Formulario con Ajax</h1>
<h3><?=$msg?></h3>

<?php $form = ActiveForm::begin(
        [ 
            "method" => "post",
            "id" => "formulario",
            "enableClientValidation" => false, // desactiva validacion del lado del cliente x defecto viene true
            "enableAjaxValidation" => true //x defecto esta en false
        ]   
    );
?>

<div class="form-group">
    <?= $form->field($model,"nombre")->input("text");?>
</div>

<div class="form-group">
    <?= $form->field($model,"email")->input("email");?>
</div>

<?= Html::submitButton("Enviar",["class" => "btn btn-primary"])?>

<?php $form->end() ?>