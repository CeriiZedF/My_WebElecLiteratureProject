<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "literature".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $author_id
 * @property int $views
 * @property int $likes
 * @property int $bookmarks
 * @property int $comments_enabled
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $author
 * @property Chapters[] $chapters
 * @property Likes[] $likesRelations
 * @property Bookmarks[] $bookmarksRelations
 */
class Literature extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'literature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['views', 'likes', 'bookmarks', 'comments_enabled'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'views' => 'Views',
            'likes' => 'Likes',
            'bookmarks' => 'Bookmarks',
            'comments_enabled' => 'Comments Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChapters()
    {
        return $this->hasMany(Chapter::className(), ['literature_id' => 'id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * Gets query for [[LikesRelations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikesRelations()
    {
        return $this->hasMany(Likes::class, ['literature_id' => 'id']);
    }

    /**
     * Gets query for [[BookmarksRelations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarksRelations()
    {
        return $this->hasMany(Bookmarks::class, ['literature_id' => 'id']);
    }
}
