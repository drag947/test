<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

use common\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class FormPay extends ActiveRecord
{

    public $status;

    public static function tableName()
    {
        return '{{%form_pay}}';
    }
    
    public static function types()
    {
        return [
            0 => Yii::t('backend', 'Manager'),
            1 => Yii::t('backend', 'Cashless'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id'], 'required'],
            [['company_user_id', 'user_id', 'type'], 'integer'],
            [['method'], 'in', 'range'=>['card','bill'], 'message' => 'Пожалуйста, перезагрузите страницу.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'Пользователь'),
            'method' => Yii::t('common', 'Способ оплаты'),
            'type' => Yii::t('common', 'Тип оплаты'),
            'company_user_id' => Yii::t('common', 'Реквизиты'),
        ];
    }

    public function getCompany()
    {
        return $this->hasOne(CompanyUser::className(), ['id' => 'company_user_id']);
    }
    
    public function type() {
        if ($this->type == 1){
            return Yii::t('backend', 'Cashless');
        }elseif($this->type == 0) {
            return Yii::t('backend', 'Manager');
        }else{
            return $this->type;
        }
    }
    
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
}