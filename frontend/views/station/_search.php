<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'installer') ?>

    <?= $form->field($model, 'user') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'cell') ?>

    <?php // echo $form->field($model, 'inverter') ?>

    <?php // echo $form->field($model, 'collector') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
