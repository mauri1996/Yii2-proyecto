<?php
use yii\helpers\Url; //trabajar con urls
use yii\helpers\Html; // trbjar con html 
use yii\widgets\ActiveForm; // activar formulario de busqueda


$this->title = 'Lista de alumnos';
$this->params['breadcrumbs'][] = $this->title;
?>

<a href="<?=Url::toRoute('site/create')?>">Crear nuevo Aumno</a>

<?php $f = ActiveForm::begin([
    "method" => 'post',
    "action" => Url::toRoute('site/view'),
    "enableClientValidation" =>true
    ]
);?>
<div class="form-group">
    <?=$f->field($form,'q')->input('search')?>
</div>

<?= Html::submitButton('Buscar',['class'=>'btn btn-primary']) ?>

<?php $f->end()?>

<h3><?=$search?></h3>

<h3>Lista de alumnos</h3>

<table class="table table-bordered">
    <tr>
        <th>Id Alumno</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Clase</th>
        <th>Nota Final</th>
        <th></th>    
        <th></th>            
    </tr>
    <?php foreach ($model as $row):?>
        <tr>
            <td><?= $row->id_alumno ?></td>
            <td><?= $row->nombre ?></td>
            <td><?= $row->apellidos ?></td>
            <td><?= $row->clase ?></td>
            <td><?= $row->nota_final ?></td>
            <td><a href="#">Editar</a></td>
            <td><a href="#">Eliminar</a></td>
        </tr>
    <?php endforeach?>

</table>

