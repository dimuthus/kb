<?php

namespace frontend\models\faq;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\faq\Faq;

/**
 * FaqmngSearch represents the model behind the search form about `frontend\models\faq\Faq`.
 */
class FaqmngSearch extends Faq
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by'], 'integer'],
            [['category_name', 'sub_category_name', 'content_qestion', 'content_answer', 'created_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Faq::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_date' => $this->created_date,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'category_name', $this->category_name])
            ->andFilterWhere(['like', 'sub_category_name', $this->sub_category_name])
            ->andFilterWhere(['like', 'content_qestion', $this->content_qestion])
            ->andFilterWhere(['like', 'content_answer', $this->content_answer]);

        return $dataProvider;
    }
}
