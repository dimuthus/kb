<?php

namespace frontend\models\forum;

use Yii;
use frontend\modules\tools\models\user\User;

/**
 * This is the model class for table "forum_replies".
 *
 * @property integer $reply_id
 * @property integer $topic_id
 * @property integer $user_id
 * @property string $message
 * @property string $date
 * @property string $ipaddress
 */
class ForumReplies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_replies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_id', 'user_id','is_deleted'], 'integer'],
            [['created_date','message'], 'safe'],
			[['message'],'required'],
            [['message'], 'string', 'max' => 500],
            [['ipaddress'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Reply ID',
            'topic_id' => 'Topic ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'created_date' => 'Date',
            'ipaddress' => 'Ipaddress',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
