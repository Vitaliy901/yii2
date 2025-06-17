<?php

namespace app\controllers;

use app\models\Review;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ReviewController extends ActiveController
{
    public $modelClass = 'app\models\Review';

    public function authenticate($token, $authMethod)
    {
        if ($token !== 'admin-token') {
            throw new UnauthorizedHttpException("Invalid token.");
        }
        return true;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // CORS fore more detailed HTTP configuration
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['update'],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['update']);
        return $actions;
    }

    public function actionUpdate($id)
    {
        $model = Review::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Review not found.");
        }

        $status = \Yii::$app->request->post('status');
        if (!in_array($status, [Review::STATUS_APPROVED, Review::STATUS_REJECTED])) {
            throw new ForbiddenHttpException("Invalid status.");
        }

        $model->status = $status;
        return $model->save() ? $model : $model->getErrors();
    }

    public function actionIndex($status = null)
    {
        $query = Review::find();

        if ($status !== null) {
            $query->where(['status' => $status]);
        }

        return $query->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function actionCreate()
    {
        $model = new Review();
        $model->load(\Yii::$app->request->post(), '');
        $model->status = Review::STATUS_PENDING;

        return $model->save() ? $model : $model->getErrors();
    }
}