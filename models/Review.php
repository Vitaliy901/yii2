<?php

namespace app\models;

use yii\db\ActiveRecord;

class Review extends ActiveRecord
{
    public $authorName;
    public $content;
    public $status;

    public static function tableName()
    {
        return '{{%reviews}}';
    }

    public function rules()
    {
        return [
            [['author_name', 'content', 'status'], 'required'],
            ['author_name', 'string', 'max' => 255],
            ['content', 'string'],
            ['status', 'in', 'range' => ['pending', 'approved', 'rejected']],
        ];
    }
}