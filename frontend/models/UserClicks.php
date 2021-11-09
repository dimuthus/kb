<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_clicks".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $url
 * @property integer $tab_id
 * @property string $click_date
 */
class UserClicks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_clicks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'tab_id'], 'integer'],
            [['click_date'], 'safe'],
            [['url'], 'string', 'max' => 255]
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
            'url' => 'Url',
            'tab_id' => 'Tab ID',
            'click_date' => 'Click Date',
        ];
    }
}
