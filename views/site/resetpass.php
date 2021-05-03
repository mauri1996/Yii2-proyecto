<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
 
<h3><?= $msg ?></h3>
 
<h1>Reset Password</h1>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    'enableClientValidation' => true,
]);
?>

<div class="form-group">
 <?= $form->field($model, "email")->input("email") ?>  
</div>
 
<div class="form-group">
 <?= $form->field($model, "password")->input("password") ?>  
</div>
 
<div class="form-group">
 <?= $form->field($model, "password_repeat")->input("password") ?>  
</div>

<div class="form-group">
 <?= $form->field($model, "verification_code")->input("text") ?>  
</div>

<div class="form-group">
 <?= $form->field($model, "recover")->input("hidden")->label(false) //para q el usuario solo pueda recuperar la password minstras esta activa la session, si cierra el navegador pierde la variable?>  
</div>
 
<?= Html::submitButton("Reset password", ["class" => "btn btn-primary"]) ?>
 
<?php $form->end() ?>