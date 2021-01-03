<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Produto */


$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="row mt-5">
        <div class="col-md-4">
            <img class="card-img-right flex-auto d-none d-md-block" src="http://rightprice.backend/<?=$model['imagem']?>" width="100%" alt="Card image cap">
        </div>
        <div class="col-md-8">
            <strong class="d-inline-block mb-2 text-primary"><?=$model['referencia']?></strong>
            <h3 class="mb-0">
                <?=$model['nome']?>
            </h3>
            <br>

            <p class="card-text mb-auto"><?=$model['descricao']?></p>
            <p class="card-text mb-auto">Preço:<?=$model['preco']?></p>

        </div>
    </div>


</div>
