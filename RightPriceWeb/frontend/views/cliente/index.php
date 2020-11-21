<?php

use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <script>
        $('select').selectpicker();
    </script>


    <p>
        <a class="btn btn-success flex-center" href="#" data-toggle="modal" data-target="#updateCliente">Adicionar Cliente</a>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nome',
            'Telemovel',
            'Nif',
            'Email:email',
            ['class' => 'app\grid\ActionColumn',
                'urlCreator' => function( $action, $model, $key, $index ){

                    if ($action == "view") {
                        return Url::to(['view', 'id' => $model['id']]);
                    }
                    if ($action == "update") {
                        return Url::to(['update', 'id' => $model['id']]);
                    }
                    if ($action == "delete") {
                        return Url::to(['delete', 'id' => $model['id']]);
                    }

                }
            ],
        ],
    ]); ?>
</div>

<div class="modal fade" id="updateCliente" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Cliente</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="container">
                <?php $form = ActiveForm::begin(['action' => 'cliente/create', 'method' => 'post']); ?>

                <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'Telemovel')->textInput() ?>

                <?= $form->field($model, 'Nif')->textInput() ?>

                <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
