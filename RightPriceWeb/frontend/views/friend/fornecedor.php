<?php


use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Obra */

?>
    <div class="container">
        <div class="row m-5">
            <a href="#">As suas conexoes</a>
        </div>
        <div class="row m-5">
            <?php for( $i=0; $i<count($data); $i++){ ?>
                <?php if($data[$i]!=null ){?>
                    <div class="card m-3" style="width: 18rem;">
                        <?php if($data[$i]['imagem']!=null ){?>

                        <?php }else{ ?>
                            <img class="card-img-top" src="img/transferir.svg" alt="Card image cap">
                        <?php } ?>
                        <div class="card-body">
                            <h5 class="card-title"><strong><?=ucfirst($data[$i]['username']) ?></strong></h5>
                            <p class="card-text"><?=ucfirst($data[$i]['nome_empresa'])?></p>
                            <p class="card-text"><?=$data[$i]['email'] ?></p>
                            <p class="card-text"><?= \app\models\Categoria::findOne($data[$i]['categoria_id'])->getCatergoriaNome() ?></p>
                            <a href="#" class="btn btn-primary">Adicionar</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

    </div>

