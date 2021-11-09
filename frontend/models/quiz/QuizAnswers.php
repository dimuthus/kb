<?php

namespace frontend\models\quiz;

use Yii;

/**
 * This is the model class for table "quiz_answers".
 *
 * @property integer $id
 * @property integer $userId
 * @property integer $questionId
 * @property string $answer
 * @property string $submitTime
 * @property string $timeTaken
 * @property string $IP
 * @property integer $testID
 * @property integer $correctness
 */
class QuizAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'questionId', 'answer', 'submitTime', 'timeTaken', 'IP'], 'required'],
            [['userId', 'questionId', 'testId', 'correctness'], 'integer'],
            [['answer', 'timeTaken'], 'string'],
            [['submitTime'], 'safe'],
            [['IP'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'questionId' => 'Question ID',
            'answer' => 'Answer',
            'submitTime' => 'Submit Time',
            'timeTaken' => 'Time Taken',
            'IP' => 'Ip',
            'testId' => 'Test Id',
            'correctness' => 'Correctness',
        ];
    }
}
