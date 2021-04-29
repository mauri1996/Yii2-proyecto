<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Hola';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Este es una pagina para saludar.!!!
    </p>

    <code><?= __FILE__ ?></code>
</div>  
