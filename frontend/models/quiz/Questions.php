<?php

namespace frontend\models\quiz;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property integer $id
 * @property integer $sequenceNo
 * @property string $question
 * @property string $answer
 * @property string $choice
 * @property integer $type
 * @property integer $testId
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sequenceNo', 'question', 'answer', 'choice', 'type', 'testId'], 'required'],
            [['sequenceNo', 'type', 'testId'], 'integer'],
            [['question', 'answer', 'choice'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sequenceNo' => 'Sequence No',
            'question' => 'Question',
            'answer' => 'Answer',
            'choice' => 'Choice',
            'type' => 'Type',
            'testId' => 'Test ID',
        ];
    }
}
