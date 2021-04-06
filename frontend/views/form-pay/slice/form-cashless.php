<?php 
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
?>

<?php $form = ActiveForm::begin(['layout'=>'horizontal','id'=>"form_pay",
	        'options'=>[
	        	'enctype' => 'multipart/form-data',
	        ],
	        'enableClientValidation' => true
	       ]); ?>
	
    <div class="js-cashless" style="display: flex; justify-content: space-between; flex-wrap:wrap;">
        <?=Html::hiddenInput('form','cashless')?>
        <div style="width: 49%;">
            <?= $form->field($model, 'status', ['template' => "{input}\n{hint}\n{error}\n",'options'=>['style'=>'margin-right:0px;margin-left:0px;']])->dropDownList($select_new, ['class'=>'js-status_bill'])->label(false)?>
        </div>
        
        <div style="width: 49%;" class="js-remove-bill">
            <?= $form->field($model, 'type', ['template' => "{input}\n{hint}\n{error}\n", 'options'=>['style'=>'margin-right:0px;margin-left:0px;']])->dropDownList([
                        'ldt' => 'ООО',
                        'sp' => 'ИП'
                    ], ['class'=>'js-type_buyer'])->label(false)?>
        </div>
        <div class="form_pay-wrap js-remove-bill">
            <?= $form->field($model, 'name', ['template' => "{input}\n{label}\n{hint}\n{error}\n",'options'=>['class'=>'form_pay-input']])->textInput()->label('Название',['class'=>'form_pay-label'])?>
        </div>
        <div class="form_pay-wrap js-ldt js-remove-bill">
            <?= $form->field($model, 'inn', ['template' => "{input}\n{label}\n{hint}\n{error}\n",'options'=>['class'=>'form_pay-input']])->textInput()->label('ИНН',['class'=>'form_pay-label'])?>
        </div>
        <div class="form_pay-wrap js-ldt js-remove-bill">
            <?= $form->field($model, 'full_name', ['template' => "{input}\n{label}\n{hint}\n{error}\n",'options'=>['class'=>'form_pay-input']])->textInput()->label('Полное название',['class'=>'form_pay-label'])?>
        </div>
        <div class="form_pay-wrap js-sp js-remove-bill" style="display: none;">
            <?= $form->field($model, 'full_name_user', ['template' => "{input}\n{label}\n{hint}\n{error}\n",'options'=>['class'=>'form_pay-input']])->textInput()->label('ФИО',['class'=>'form_pay-label'])?>
        </div>
        <div class="form_pay-wrap js-sp js-remove-bill" style="display: none;">
            <?= $form->field($model, 'phone', ['template' => "{input}\n{label}\n{hint}\n{error}\n",'options'=>['class'=>'form_pay-input']])->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '[+380]99-999-9999',
])->label('Телефон',['class'=>'form_pay-label'])?>
        </div>
        
    </div>
    <div class="form_pay-wrap">
        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success', 'id' => 'js-submit']) ?>
    </div>
<?php ActiveForm::end(); ?>