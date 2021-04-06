<?php 
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
?>

<?php $form = ActiveForm::begin(['layout'=>'horizontal','id'=>"form_pay",
            'options'=>[
                    'enctype' => 'multipart/form-data',
            ],
            'enableClientValidation' => false
           ]); ?>
    <div style="width: 49%;">
    <?=Html::hiddenInput('form','manager')?>
    <?= $form->field($model, 'method', ['template' => "{input}\n{hint}\n{error}\n", 'options'=>['style'=>'margin-right:0px;margin-left:0px;']])->dropDownList([
                                'card' => 'Оплата на карту',
                                'bill' => 'Оплата счетом'
                            ], ['style'=>'padding:5px;'])->label(false)?>
    </div>

    <div style="margin-top: 30px;">
            <p>
            После оформления заказа наш менеджер свяжется с вами по телефону и поможет провести оплату удобным для Вас способом
            </p>
    </div>
    <div class="form_pay-wrap">
        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success', 'id' => 'js-submit']) ?>
    </div>
<?php ActiveForm::end(); ?>

