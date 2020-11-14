<?php

use yii\helpers\ArrayHelper;
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

    <p>
        <?= Html::a('Create Cliente', ['create'], ['class' => 'btn btn-success']) ?>
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
