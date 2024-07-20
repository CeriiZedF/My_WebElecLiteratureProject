<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Chapter extends ActiveRecord
{
    public static function tableName()
    {
        return 'Chapters';
    }

    public function rules()
    {
        return [
            [['title', 'literature_id'], 'required'],
            [['description'], 'string'],
            [['literature_id', 'views', 'likes', 'bookmarks', 'comments_enabled'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'literature_id' => 'Literature ID',
            'views' => 'Views',
            'likes' => 'Likes',
            'bookmarks' => 'Bookmarks',
            'comments_enabled' => 'Comments Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
