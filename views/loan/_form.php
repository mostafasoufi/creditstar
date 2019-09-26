<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Standard;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Loan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'first_name'), ['prompt' => 'Select User']) ?>
    <?= $form->field($model, 'amount')->textInput() ?>
    <?= $form->field($model, 'interest')->textInput() ?>
    <?= $form->field($model, 'duration')->textInput() ?>
    <?= $form->field($model, 'start_date')->textInput(['type' => 'date']) ?>
    <?= $form->field($model, 'end_date')->textInput(['type' => 'date']) ?>
    <?= $form->field($model, 'campaign')->textInput() ?>
    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
