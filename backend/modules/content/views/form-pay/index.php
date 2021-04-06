<?php

use frontend\models\FormPay;
use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


$this->title = Yii::t('backend', 'Queryies');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">

    <div class="card-body p-0">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'options' => [
                'class' => ['gridview', 'table-responsive'],
            ],
            'tableOptions' => [
                'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0', 'table-sm'],
            ],
            'columns' => [
                [
                    'attribute' => 'id',
                    'options' => ['style' => 'width: 5%'],
                ],
                [
                    'attribute' => 'type',
                    'options' => ['style' => 'width: 15%'],
                    'filter' => FormPay::types(),
                    'value' => function ($model) {
                        return $model->type();
                    },
                ],
                [
                    'attribute' => 'requisites',
                    'options' => ['style' => 'width: 15%'],
                    'value' => function ($model) {
                        return $model->company ? $model->company->type().' '.$model->company->name : '';
                    },
                ],
                [
                    'class' => \common\widgets\ActionColumn::class,
                    'options' => ['style' => 'width: 5%'],
                    'template' => '{view}',
                ],
            ],
        ]); ?>
    </div>

    <div class="card-footer">
        <?php echo getDataProviderSummary($dataProvider) ?>
    </div>
</div>


