<?php

use app\models\User;
use RKD\PersonalIdCode\PersonalIdCode;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'first_name:ntext',
            'last_name:ntext',
            'email:ntext',
            [
                'label' => 'Age',
                'value' => function ($model) {
                    $id = new PersonalIdCode($model->personal_code);
                    return $id->getAge();
                }
            ],
            [
                'label' => 'Gender',
                'value' => function ($model) {
                    $id = new PersonalIdCode($model->personal_code);
                    return ucfirst($id->getGender());
                }
            ],
            'personal_code',
            'phone',
            //'active:boolean',
            //'dead:boolean',
            //'lang:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
