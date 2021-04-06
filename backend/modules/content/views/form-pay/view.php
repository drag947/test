<?php

use yii\widgets\DetailView;

$this->title = Yii::t('backend', 'Query').': '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Queryies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="table-content  table-admin-container">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'type',
                'format' => 'html',
                'value' => function ($data) {
                    return $data->type(); 
                },
            ],  
            [
                'attribute' => 'method',
                'format' => 'html',
                'value' => function ($data) {
                    if($data->type == 0)
                        if ($data->method == 'card') {
                            return Yii::t('сommon', 'Оплата на карту'); 
                        }elseif($data->method == 'bill') {
                            return Yii::t('сommon', 'Оплата счетом'); 
                        }else{
                            return $data->method; 
                        }
                    else
                        return Yii::t('сommon', 'Безналичный расчет');
                },
            ],
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => function ($data) {
                    return $data->user->username; 
                },
            ], 
        ],
    ]) ?>
    <?php if($model->company) :  
        $fields = $model->company->scenarios()[$model->company->type];
        unset($fields[array_search('type',$fields)]); 
        unset($fields[array_search('user_id',$fields)]);
    ?>
        <h3><?=Yii::t('сommon', 'Requisites')?></h3>
        <?= DetailView::widget([
            'model' => $model->company,
            'attributes' => array_merge([
                [
                    'attribute' => 'type',
                    'format' => 'html',
                    'value' => function ($data) {
                        return $data->type(); 
                    },
                ],
                
            ],$fields),
        ]) ?>
    <?php endif;?>
</div>