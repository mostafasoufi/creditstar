<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Loan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'User',
                'value' => function ($model) {
                    $user = User::findOne($model->user_id);
                    if ($user) {
                        return $user->first_name . ' ' . $user->last_name;
                    } else {
                        return 'User deleted.';
                    }
                }
            ],
            [
                'label' => 'Amount',
                'value' => function ($model) {
                    return sprintf('%s €', $model->amount);
                }
            ],
            [
                'label' => 'Interest',
                'value' => function ($model) {
                    return sprintf('%s €', $model->interest);
                }
            ],
            'duration',
            'start_date',
            'end_date',
            //'campaign',
            'status:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
