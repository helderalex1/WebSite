<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'fornecedor_id',
            //'imagem',
            'nome',
            'referencia',
            'descricao',
            'preco',

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
