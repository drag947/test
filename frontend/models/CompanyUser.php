<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * ContactForm is the model behind the contact form.
 */
class CompanyUser extends ActiveRecord
{

    public $status;

    public static function tableName()
    {
        return '{{%company_user}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'inn', 'full_name_user', 'phone','full_name', 'name'], 'required'],
            [['inn', 'full_name_user'], 'string', 'max'=>255],
            [['full_name'], 'string'],
            [['user_id'], 'integer'],
            [['phone'], 'match', 'pattern'=>'/^\+380[0-9][0-9]-[0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]$/', 'message'=>Yii::t('common', 'Номер телефона должен быть в формате +380**-***-****')],
            [['type'], 'in', 'range'=>['sp','ldt']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'inn' => Yii::t('common', 'ИНН'),
            'full_name_user' => Yii::t('common', 'ФИО'),
            'phone' => Yii::t('common', 'Телефон'),
            'full_name' => Yii::t('common', 'Полное название'),
            'name' => Yii::t('common', 'Название'),
            'user_id' => Yii::t('common', 'Пользователь'),
            'type' => Yii::t('common', 'Тип плательщика'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $default = ['type', 'user_id', 'name'];
        $scenarios['ldt'] = array_merge($default, ['inn', 'full_name']);
        $scenarios['sp']  = array_merge($default, ['full_name_user', 'phone']);
        return $scenarios;
    }
    
    public function type() {
        if ($this->type == 'ltd'){
            return Yii::t('backend', 'LTD');
        }elseif($this->type == 'sp') {
            return Yii::t('backend', 'SP');
        }else{
            return $this->type;
        }
    }
    
}