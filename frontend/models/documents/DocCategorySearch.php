<?php

namespace frontend\models\documents;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\documents\Documents;
use frontend\models\documents\DocCategory;

/**
 * DocumentsSearch represents the model behind the search form about `frontend\models\documents\Documents`.
 */
class docCategorySearch extends DocCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deleted'], 'integer'],
            [['name', 'description'], 'string', 'max' => 250],
            [['created_date'],'safe']
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
        $query = DocCategory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //$dataProvider->sort=false;
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        //var_dump($query);
        //die();
        return $dataProvider;
    }
}
