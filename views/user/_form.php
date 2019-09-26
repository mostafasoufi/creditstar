<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->input([]) ?>
    <?= $form->field($model, 'last_name')->input([]) ?>
    <?= $form->field($model, 'email')->input([]) ?>
    <?= $form->field($model, 'personal_code')->textInput() ?>
    <?= $form->field($model, 'phone')->textInput() ?>
    <?= $form->field($model, 'active')->checkbox() ?>
    <?= $form->field($model, 'dead')->checkbox() ?>
    <?= $form->field($model, 'lang')->input([]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
