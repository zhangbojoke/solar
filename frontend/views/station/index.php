<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\StationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Station', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'installer',
            'user',
            'status',
            'created_at',
            //'location',
            //'cell:ntext',
            //'inverter:ntext',
            //'collector:ntext',
            //'type',
            //'title',
            //'remark',
            //'update_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
