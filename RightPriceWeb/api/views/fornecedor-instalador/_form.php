<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FornecedorInstalador */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fornecedor-instalador-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fornecedor_id')->textInput() ?>

    <?= $form->field($model, 'instalador_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
