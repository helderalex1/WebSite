<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /* Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

    <div class="row m-5">
        <div class="col-md-4">
            <img class="card-img-right flex-auto d-none d-md-block" src="http://rightprice.backend/<?=$model['imagem']?>" width="100%" alt="Card image cap">
        </div>
        <div class="col-md-8">
            <strong class="d-inline-block mb-2 text-primary"><?=$model['username']?></strong>
            <h3 class="mb-0"><?=$model['nome_empresa']?></h3>
            <p class="mb-0"><?=$model['nome']?></p>
            <br>
            <p class="card-text mb-auto"><?=$model['telemovel']?></p>
            <p class="card-text mb-auto"><?=$model['email']?></p>

        </div>
    </div>

</div>
