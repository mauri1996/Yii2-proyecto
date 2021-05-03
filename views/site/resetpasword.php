<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Restablecer Contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Ingresar nueva contraseña:</p>    

    <?php $form = ActiveForm::begin([
        'id' => 'resetPassword-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>        

        <?= $form->field($model, 'password')->passwordInput() ?>
        
        <?= $form->field($model, "password_repeat")->input("password") ?>   
        

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Confirmar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <h3><?=$msg?></h3>

    <?php ActiveForm::end(); ?>

</div>
