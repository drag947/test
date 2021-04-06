<?php
/**
 * Require core files
 */
require_once __DIR__ . '/../helpers.php';

/**
 * Setting path aliases
 */
Yii::setAlias('@base', dirname(__DIR__) . '/../');
Yii::setAlias('@common', dirname(__DIR__) . '/../common');
Yii::setAlias('@api', dirname(__DIR__) . '/../api');
Yii::setAlias('@frontend', dirname(__DIR__) . '/../frontend');
Yii::setAlias('@backend', dirname(__DIR__) . '/../backend');
Yii::setAlias('@console', dirname(__DIR__) . '/../console');
Yii::setAlias('@storage', dirname(__DIR__) . '/../storage');
Yii::setAlias('@tests', dirname(__DIR__) . '/../tests');

/**
 * Setting url aliases
 */
Yii::setAlias('@apiUrl', env('API_HOST_INFO') . env('API_BASE_URL'));
Yii::setAlias('@frontendUrl', env('FRONTEND_HOST_INFO') . env('FRONTEND_BASE_URL'));
Yii::setAlias('@backendUrl', env('BACKEND_HOST_INFO') . env('BACKEND_BASE_URL'));
Yii::setAlias('@storageUrl', env('STORAGE_HOST_INFO') . env('STORAGE_BASE_URL'));



