<?php

use Codeception\PHPUnit\ResultPrinter\HTML as ResultPrinterHTML;
use yii\helpers\Url; //trabajar con urls
use yii\helpers\Html; // trbjar con html 

?>

<h1>Formulario</h1>
<h3><?= $mensaje?></h3>
<?= 
    Html::beginForm(
        Url::toRoute("site/request"), // acctions function actionRequest() -> siteController
        "get", // metodo
        ['class' => 'form-inline'] // opctiones
    );
?>
    <div class="form-group">
        <?= Html::label("Introduce tu nombre","nombre");?>
        <?= Html::textInput("nombre",null,["class" => "form-control"]);?>        
    </div>
    <?= Html::submitInput("Enviar tu nombre",["class" => "bn btn-primary"]);?>

<?= Html::endForm()?>

