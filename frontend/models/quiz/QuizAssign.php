<?php

namespace frontend\models\quiz;
use frontend\modules\tools\models\user\User;
use frontend\models\quiz\QuizDescription;

use Yii;

/**
 * This is the model class for table "quiz_assign".
 *
 * @property integer $user_id
 * @property integer $quiz_id
 * @property string $assign_date
 * @property string $completed_date
 */
class QuizAssign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_assign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'quiz_id'], 'integer'],
            [['assign_date', 'completed_date'], 'safe'],
            [['score'], 'number'],
            [['user_id', 'quiz_id'], 'required'],
            [['results'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'quiz_id' => 'Quiz ID',
            'assign_date' => 'Assign Date',
            'completed_date' => 'Completed Date',
            'score' => 'Score (%)',
            'results' => 'Results',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getQuizdescription()
    {
        return $this->hasOne(QuizDescription::className(), ['id' => 'quiz_id']);
    }
}
