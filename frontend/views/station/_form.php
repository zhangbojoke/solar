<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Station */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="station-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'installer')->textInput() ?>

    <?= $form->field($model, 'user')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cell')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'inverter')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'collector')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
