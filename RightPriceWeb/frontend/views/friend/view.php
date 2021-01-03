<?php


use common\models\Categoria;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Obra */

?>
<div class="container">
    <div class="row m-5">
        <p>
            <a href="<?= Url::toRoute(['friend/view']) ?>">As suas conexões</a>
        </p>
        <p class="ml-5">
            <a href="<?= Url::toRoute(['friend/index']) ?>">Adicionar Fornecedores</a>
        </p>
    </div>
    <?php if(count($data)!=0){ ?>
        <div class="row m-5">
            <?php for( $i=0; $i<count($data); $i++){ ?>
                <?php if($data[$i]!=null ){?>
                    <div id="<?=ucfirst($data[$i]['username']) ?>" class="card m-3" style="width: 18rem;">
                        <?php if($data[$i]['imagem']!=null ){?>
                            <img class="card-img-top" src="<?=$data[$i]['imagem'] ?>" alt="Card image cap">
                        <?php } ?>
                        <div class="card-body">
                            <h5 class="card-title"><strong><?=ucfirst($data[$i]['username']) ?></strong></h5>
                            <p class="card-text"><?=ucfirst($data[$i]['nome_empresa'])?></p>
                            <p class="card-text"><?=$data[$i]['email'] ?></p>
                            <p class="card-text"><?= Categoria::findOne($data[$i]['categoria_id'])->getCatergoriaNome() ?></p>
                            <a href="<?= Url::toRoute(['friend/removefriend', 'id' => $data[$i]['id']]) ?>" class="btn btn-danger">Remover</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
    <?php if(count($data)==0){ ?>
    <p>Ainda não adicionou nenhum fornecedor</p>
    <?php }?>
</div>