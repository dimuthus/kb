<?php

namespace frontend\models\faq;

use Yii;

/**
 * This is the model class for table "faq_favourite_log".
 *
 * @property integer $id
 * @property integer $ref_id
 * @property int $faq_id
 * @property int $user_id
 * @property int $isfavourite
 * @property string $created_date
 * @property string $action

 */
class Faqfavlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq_favourite_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_date'], 'string'],
            [['user_id', 'faq_id'], 'required'],
            [['created_date', 'action', 'ref_id'], 'safe'],
            [['ref_id', 'user_id', 'faq_id', 'isfavourite'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_id' => 'Reff ID',
            'user_id' => 'User',
            'faq_id' => 'Faq ID',
            'isfavourite' => 'isfavourite',
            'created_date' => 'Created Date',
        ];
    }
}
