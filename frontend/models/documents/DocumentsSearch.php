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
class DocumentsSearch extends Documents
{
    /**
     * @inheritdoc
     */
    public $category;
    public function rules()
    {
        return [
            [['id', 'category_id', 'totalbytes', 'visited_count', 'acknowledge', 'deleted'], 'integer'],
            [['original_filename', 'uploaded_date', 'modify_date', 'description','category'], 'safe'],
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
        $query = Documents::find()->where('documents.deleted=0');
        $query->joinWith(['doccategory']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //$dataProvider->sort=false;
        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
           // 'id' => $this->id,
            'totalbytes' => $this->totalbytes,
           // 'uploaded_date' => $this->uploaded_date,
           // 'modify_date' => $this->modify_date,
           // 'visited_count' => $this->visited_count,
            //'acknowledge' => $this->acknowledge,
            //'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'documents.original_filename', $this->original_filename])
            ->andFilterWhere(['like', 'documents.description', $this->description])
            ->andFilterWhere(['like', 'doc_category.name', $this->category])
            ->andFilterWhere(['like', 'uploaded_date', $this->uploaded_date]);

        $query->orderby('name');

        return $dataProvider;
    }

}
