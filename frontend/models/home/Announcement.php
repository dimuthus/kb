<?php

namespace frontend\models\home;

use Yii;

/**
 * This is the model class for table "annoucement".
 *
 * @property integer $id
 * @property string $title
 * @property string $message
 * @property string $creation_date
 * @property string $updated_date
 * @property integer $active
 */
class Announcement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'announcement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'message'], 'required'],
            [['creation_date', 'updated_date'], 'safe'],
            [['active'], 'integer'],
            [['title'], 'string', 'max' => 500],
            [['message'], 'string', 'max' => 1000]
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
            'message' => 'Message',
            'creation_date' => 'Creation Date',
            'updated_date' => 'Updated Date',
            'active' => 'Active',
        ];
    }
}
