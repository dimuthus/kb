<?php

namespace frontend\models\feedback;

use Yii;
use frontend\modules\tools\models\user\User;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $subject
 * @property integer $user_id
 * @property string $content
 * @property string $datetime
 * @property integer $seen
 * @property string $reply
 * @property integer $adminseen
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'content'], 'required'],
            [['user_id', 'seen', 'adminseen','is_deleted'], 'integer'],
            [['content', 'reply'], 'string'],
            [['datetime'], 'safe'],
            [['subject'], 'string', 'max' => 2000]
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'user_id' => 'User ID',
            'content' => 'Content',
            'datetime' => 'Datetime',
            'seen' => 'Seen',
            'reply' => 'Reply',
            'adminseen' => 'Adminseen',
            'is_deleted' => 'Deleted',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
