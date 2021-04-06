<?php 
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
?>
<div class="message"></div>
<div class="form_pay-body">
	
	<h1>Способ оплаты</h1>
	
	<select style="width: 100%;" id="js-type-form">
            <option value="manager" selected>Оплатить счетом через менеджера</option>
            <option value="cashless">Безналичный расчет</option>
	</select>
	<div class="js-form">
            <?php  require 'slice/form-manager.php';?>
	</div>
</div>