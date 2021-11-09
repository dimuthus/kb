<?php

namespace frontend\models\documents;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\documents\Documents;
use frontend\models\documents\DocVisiting;
use frontend\models\documents\DocumentsRating;

/**
 * DocumentsSearch represents the model behind the search form about `frontend\models\documents\Documents`.
 */
class DocVisitingSearch extends DocVisiting
{
    /**
     * @inheritdoc
     */
    public $rating;
    public function rules()
    {
        return [
            [['id', 'category_id', 'totalbytes', 'visited_count', 'acknowledge', 'deleted'], 'integer'],
            [['original_filename', 'uploaded_date', 'modify_date', 'description','rating'], 'safe'],
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
         $query = DocVisiting::find()->select(['documents.id,original_filename,description,visited_count,acknowledge,COUNT(rating) AS docRating'])
                ->where('documents.deleted=0')
                ->groupBy('documents.id')
				->joinWith(['documentsrating']);
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
            //'totalbytes' => $this->totalbytes,
           // 'uploaded_date' => $this->uploaded_date,
           // 'modify_date' => $this->modify_date,
            'visited_count' => $this->visited_count,
            //'acknowledge' => $this->acknowledge,
            //'documents_rating.rating' => $this->rating,
        ]);

        $query->andFilterWhere(['like', 'documents.original_filename', $this->original_filename])
            ->andFilterWhere(['like', 'documents.description', $this->description]);
        
        $query->orderby('documents.original_filename');
        //$query->where(['documents.deleted'=>0]);
        //var_dump($query);
        //die();
        return $dataProvider;
    }

}
