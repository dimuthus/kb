<?php

namespace frontend\models\feedback;
use frontend\modules\tools\models\user\User;

use Yii;

/**
 * This is the model class for table "feedback_replies".
 *
 * @property integer $id
 * @property integer $feedback_id
 * @property integer $user_id
 * @property string $reply
 * @property string $created_date
 */
class FeedbackReplies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback_replies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feedback_id', 'user_id'], 'integer'],
            [['created_date','reply'], 'safe'],
            [['reply'], 'string', 'max' => 255],
            [['reply'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'feedback_id' => 'Feedback ID',
            'user_id' => 'User ID',
            'reply' => 'Reply',
            'created_date' => 'Created Date',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
