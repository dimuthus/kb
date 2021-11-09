<?php

namespace frontend\models\quiz;


use Yii;

/**
 * This is the model class for table "quiz_description".
 *
 * @property integer $id
 * @property string $title
 * @property resource $description
 * @property string $startTime
 * @property string $stopTime
 * @property integer $duration
 * @property integer $verifyAnswer
 * @property integer $maxSkips
 * @property integer $noOfQuestion
 * @property integer $passRate
 */
class QuizDescription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_description';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'startTime', 'stopTime', 'duration', 'verifyAnswer', 'maxSkips','noOfQuestion','passRate','file_name'], 'required'],
            [['title', 'description','file_name'], 'string'],
            [['startTime', 'stopTime','uploaded_date'], 'safe'],
            [['duration', 'verifyAnswer', 'maxSkips', 'noOfQuestion', 'passRate','uploaded_by'], 'integer'],
            [['file_name'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'startTime' => 'Start Time',
            'stopTime' => 'Stop Time',
            'duration' => 'Duration',
            'verifyAnswer' => 'Verify Answer',
            'maxSkips' => 'Max Skips',
            'noOfQuestion' => 'No Of Question',
            'passRate' => 'Pass Rate',
            'uploaded_date'=>'Uploaded Date',
            'uploaded_by'=>'Uploaded By',
            'file_name'=>'File Name',
        ];
    }
    public function getQuizAssign()
    {
        return $this->hasOne(QuizAssign::className(), ['quiz_id' => 'id']);
    }
    
}
