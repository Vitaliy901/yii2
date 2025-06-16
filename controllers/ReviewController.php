<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\filters\Cors;
use app\models\Review;
use yii\web\NotFoundHttpException;



class ReviewController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['update'],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['update'],
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function () {
                        return Yii::$app->request->headers->get('Authorization') === 'Bearer admin-token';
                    },
                ],
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $review = new Review();
        $review->load(Yii::$app->request->post(), '');
        $review->status = Review::STATUS_PENDING;
        if ($review->save()) {
            return $review;
        }
        return $review->errors;
    }

    public function actionIndex($status = null)
    {
        $query = Review::find();
        if ($status) {
            $query->andWhere(['status' => $status]);
        }
        return $query->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function actionUpdate($id)
    {
        $review = Review::findOne($id);
        if (!$review) {
            throw new NotFoundHttpException();
        }
        $data = Yii::$app->request->bodyParams;
        if (isset($data['status']) && in_array($data['status'], [Review::STATUS_APPROVED, Review::STATUS_REJECTED])) {
            $review->status = $data['status'];
            if ($review->save()) {
                return $review;
            }
        }
        return ['error' => 'Invalid data'];
    }

    public function actionAdmin()
    {
        return $this->render('admin');
    }
}