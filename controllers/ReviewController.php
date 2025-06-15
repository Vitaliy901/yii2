<?php

namespace app\controllers;

use app\models\Review;
use yii\web\Controller;

class ReviewController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Review::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'reviews' => $countries,
            'pagination' => $pagination,
        ]);
    }

}
