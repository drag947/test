<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AjaxFilter;
use yii\filters\AccessControl;
use frontend\models\FormPay;
use frontend\models\CompanyUser;


class FormPayController extends Controller
{

	public function behaviors()
	{
	    return [
	    	[
	        'class' => 'yii\filters\AjaxFilter',
                'only' => ['save-form', 'get-form', 'get-bill']
        	],
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['save-form', 'get-bill'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
	    ];
	}

	public function actionIndex() {

            $model = new FormPay();
            $company = new CompanyUser();

            return $this->render('index', [
                    'model'=>$model,
                    'company'=>$company,
                    'select_new' => ['new'=>'Создать новый']
            ]);
	}

	public function actionSaveForm() {
            $post = Yii::$app->request->post();
            if(!isset($post['form'])) {
                return false;
            } 
            $model = new FormPay();
            if($post['form'] == 'manager') {
                if($model->load($post)){
                    $model->user_id = Yii::$app->user->id;
                    $model->type = 0;
                    if($model->save()) {
                        return json_encode(['result'=>'success','message'=>'Заявка успешно оставленна. Менеджер с Вами свяжется!']);
                    }else{
                        $resutl = $this->errorsStr($model);
                        return json_encode(['result'=>'danger','message'=>$result]);
                    }
                }
            }elseif($post['form'] == 'cashless'){
                $model->user_id = Yii::$app->user->id;
                $model->type = 1;
                $is_save_comp = false;
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if(isset($post['CompanyUser']['status']) && (int)$post['CompanyUser']['status'] > 0) {
                        $company = CompanyUser::findOne((int)$post['CompanyUser']['status']);
                        if(!$company) {
                            return json_encode(['result'=>'danger','message'=>'Не найдены реквизиты']);
                        }
                        $is_save_comp = true;
                    }else{
                        if(!isset($post['CompanyUser']['type']) || !in_array($post['CompanyUser']['type'], ['sp','ldt'])) {
                            return json_encode(['result'=>'danger','message'=>'Тип плательщика выбран не верно!']);
                        }
                        $company = new CompanyUser(['scenario' => $post['CompanyUser']['type']]);
                        $company->user_id = $model->user_id;
                        if( $company->load($post) && $company->save() ) {
                            $is_save_comp = true;
                        }else{
                            $transaction->rollBack();
                            return json_encode(['result'=>'danger','message'=>$this->errorsStr($company)]);
                        }
                    }
                    if( $is_save_comp ){
                        $model->company_user_id = $company->id;
                        if($model->save()) {
                            $transaction->commit();
                            return json_encode(['result'=>'success','message'=>'Данные успешно сохранены!']);
                        }else{
                            $transaction->rollBack();
                            return json_encode(['result'=>'danger','message'=>$this->errorsStr($model)]);
                        }
                    }
                } catch(\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                } catch(\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
            
	}
        
        private function errorsStr($model) {
            $result = '';
            foreach ($model->getErrors() as $attribute => $error)
            {
                foreach ($error as $message)
                {
                    $result = $message.'<br>';
                }
            }
            return $result;
        }

	public function actionGetForm() {
            $post = Yii::$app->request->post('form');
            if(!$post || !in_array($post, ['manager','cashless'])){
                return false;
            }
            return $this->getForm($post);
	}
        
        private function getForm($form) {
            $select_new = false;
            if($form == 'manager') {
                $model = new FormPay();
            }else{
                $select_new = ['new'=>'Создать новый'];
                $model = new CompanyUser();
                $find_company = CompanyUser::findAll(['user_id'=>Yii::$app->user->id]);
                foreach ($find_company as $company) {
                    $select_new[$company->id] = $company->name;
                }
            }
            
            return $this->renderAjax('slice/form-'.$form, [
                    'model'=>$model,
                    'select_new' => $select_new
            ]);
        }
        
        public function actionGetBill() {
            $id = Yii::$app->request->post('id');
            $bill = CompanyUser::find()
                    ->where(['id'=>$id, 'user_id'=>Yii::$app->user->id])
                    ->limit(1)->one();
            if($bill) {
                return $this->renderAjax('slice/bill', [
                        'fields'=>$bill,
                        'model'=>new CompanyUser()
                    ]);
            }
            return $this->getForm('cashless');
        }

}