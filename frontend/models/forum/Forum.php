<?php

namespace frontend\models\forum;
use Yii;
use frontend\modules\tools\models\user\User;

/**
 * This is the model class for table "forum_topics".
 *
 * @property integer $id
 * @property string $title
 * @property string $detail
 * @property string $date
 * @property integer $createdby
 * @property string $ipaddress
 */
class Forum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_topics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'details'], 'required'],
            [['details'], 'string'],
            [['created_date'], 'safe'],
            [['createdby'], 'integer'],
            [['title'], 'string', 'max' => 500],
            [['ipaddress'], 'string', 'max' => 45],
            [['is_deleted'],'integer']
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
            'details' => 'Details',
            'created_date' => 'Date',
            'createdby' => 'Created By',
            'ipaddress' => 'Ipaddress',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function getForumReplies()
    {
        return $this->hasOne(ForumReplies::className(), ['topic_id' => 'id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'createdby']);
    }
}
