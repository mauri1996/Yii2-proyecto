<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

// A para ir a la vista
?>
<a href="<?=Url::toRoute('site/view')?>">Ver lista de alumnos</a>

<!--h1>Actualizar Alumno con id <?//= Html::encode($_GET['id_alumno'])?></h1-->
<h1>Actualizar el alumno: <?=$name?></h1>

<h3><?=$msg?></h3>

<?php $form = ActiveForm::begin(
        [ 
            "method" => "post",                      
            "enableClientValidation" => true
            
        ]   
    );
?>


<?= $form->field($model,"id_alumno")->input("hidden")->label(false) ?>

<div class="form-group">
    <?= $form->field($model,"nombre")->input("text");?>
</div>

<div class="form-group">
    <?= $form->field($model,"apellidos")->input("text");?>
</div>

<div class="form-group">
    <?= $form->field($model,"clase")->input("text");?>
</div>

<div class="form-group">
    <?= $form->field($model,"nota_final")->input("text");?>
</div>

<?= Html::submitButton("Actualizar",["class" => "btn btn-primary"])?>

<?php $form->end() ?>