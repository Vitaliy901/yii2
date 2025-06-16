<?php

namespace app\models;

use yii\db\ActiveRecord;

class Review extends ActiveRecord
{
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public static function tableName() {
        return 'reviews';
    }

    public function rules() {
        return [
            [['author_name', 'string'], 'required'],
            [['content'], 'text'],
            [['author_name'], 'string', 'max' => 255],
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_APPROVED, self::STATUS_REJECTED]],
        ];
    }
}