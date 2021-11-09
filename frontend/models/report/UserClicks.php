<?php

namespace frontend\models\report;
use frontend\modules\tools\models\user\User;
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
            [['click_date','url'], 'safe'],
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
            'url' => 'Page',
            'tab_id' => 'Tab ID',
            'click_date' => 'Click Date',
            'user.username'=>'User Name'
        ];
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
