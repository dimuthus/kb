<?php

namespace frontend\models\documents;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\documents\DocAcknowledge;

/**
 * DocAcknowledgeSearch represents the model behind the search form about `frontend\models\documents\DocAcknowledge`.
 */
class DocAcknowledgeSearch extends DocAcknowledge
{
    /**
     * @inheritdoc
     */
    public $user;
    public $document;
    public $description;
    public function rules()
    {
        return [
            [['id', 'user_id', 'doc_id'], 'integer'],
             [['aknowledge_date','document','user','description'], 'safe']
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
        $query = DocAcknowledge::find()->where('documents.deleted=0');
        $query->joinWith(['user','documents']);
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
            'user_id' => $this->user_id,
            'doc_id' => $this->doc_id,
           // 'aknowledge_date' => $this->aknowledge_date,
        ]);
        $query->andFilterWhere(['like', 'user.username', $this->user]);
        $query->andFilterWhere(['like', 'documents.original_filename', $this->document]);
        $query->andFilterWhere(['like', 'documents.description', $this->description]);
        $query->andFilterWhere(['like', 'aknowledge_date', $this->aknowledge_date]);
        $query->orderby('documents.original_filename');
        //$query->where(['documents.deleted'=>0]);
        
        return $dataProvider;
    }
    
}
