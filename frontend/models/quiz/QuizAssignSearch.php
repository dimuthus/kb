<?php

namespace frontend\models\quiz;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\quiz\QuizAssign;

/**
 * QuizParticipantsSearch represents the model behind the search form about `frontend\models\quiz\QuizParticipants`.
 */
class QuizAssignSearch extends QuizAssign
{
    /**
     * @inheritdoc
     */
    public $user;
    public $quiz;
    public function rules()
    {
        return [
            [['id', 'user_id', 'quiz_id'], 'integer'],
            [['assign_date', 'completed_date', 'results','user','quiz'], 'safe'],
            [['score'], 'number'],
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
        $query = QuizAssign::find();
        
        $query->joinWith(['user', 'quizdescription']);
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
            'quiz_id' => $this->quiz_id,
            'assign_date' => $this->assign_date,
            'completed_date' => $this->completed_date,
            'score' => $this->score,
        ]);

        $query->andFilterWhere(['like', 'results', $this->results]);
        $query->andFilterWhere(['like', 'username', $this->user]);
        $query->andFilterWhere(['like', 'title', $this->quiz]);

        return $dataProvider;
    }
}
