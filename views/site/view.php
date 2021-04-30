<?php
use yii\helpers\Url; //trabajar con urls
use yii\helpers\Html; // trbjar con html 
use yii\widgets\ActiveForm; // activar formulario de busqueda


/// para paginacion
use yii\data\Pagination;
use yii\widgets\LinkPager;

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
            <td>
                <a href="#" data-toggle="modal" data-target="#id_alumno_<?= $row->id_alumno ?>">Eliminar</a>
                <div class="modal fade" role="dialog" aria-hidden="true" id="id_alumno_<?= $row->id_alumno ?>">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title">Eliminar alumno</h4>
                                </div>
                                <div class="modal-body">
                                        <p>¿Realmente deseas eliminar al alumno con id <?= $row->id_alumno ?>?</p>
                                </div>
                                <div class="modal-footer">
                                <?= Html::beginForm(Url::toRoute("site/delete"), "POST") ?>
                                        <input type="hidden" name="id_alumno" value="<?= $row->id_alumno ?>">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Eliminar</button>
                                <?= Html::endForm() ?>
                                </div>
                                </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->                    
            </td>
        </tr>
    <?php endforeach?>

</table>

<?= // paginacion
    LinkPager::widget([
        'pagination'=>$pages,
    ]); ?>