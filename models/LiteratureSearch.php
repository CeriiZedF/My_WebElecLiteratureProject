<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Literature;

class LiteratureSearch extends Model
{
    public $title;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'safe'],
        ];
    }

    /**
     * Creates a data provider instance with search query applied.
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Literature::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5, 
            ],
            'sort' => [
                'defaultOrder' => ['title' => SORT_ASC], 
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
