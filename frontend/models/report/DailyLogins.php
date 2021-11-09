<?php

namespace frontend\models\report;
use frontend\modules\tools\models\user\User;

use Yii;

/**
 * This is the model class for table "daily_logins".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $login_date
 */
class DailyLogins extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
   public $cLogins;
   public $loginDate;
    public static function tableName()
    {
        return 'daily_logins';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['login_date'], 'safe']
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
            'login_date' => 'Login Date',
            'cLogins'=>'Total Logins',
            'loginDate'=>'Login Date',
        ];
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
