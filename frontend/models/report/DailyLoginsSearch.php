<?php

namespace frontend\models\report;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\report\DailyLogins;

/**
 * DailyLoginsSearch represents the model behind the search form about `frontend\models\report\DailyLogins`.
 */
class DailyLoginsSearch extends DailyLogins
{
    /**
     * @inheritdoc
     */
    
    public $user;
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['login_date','user'], 'safe'],
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
        $query = DailyLogins::find()->select('user_id, Date(login_date) as loginDate,COUNT(*) AS cLogins')->groupBy(['user_id','loginDate']);
        $query->joinWith(['user']);
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
        ]);
        $query->andFilterWhere(['like', 'username', $this->user]);
        $query->andFilterWhere(['like', 'login_date', $this->login_date]);

        return $dataProvider;
    }
}
