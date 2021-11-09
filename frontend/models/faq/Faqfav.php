<?php

namespace frontend\models\faq;

use Yii;

/**
 * This is the model class for table "faq_favourite".
 *
 * @property integer $id
 * @property int $user_id
 * @property int $faq_id
 * @property integer $isfavourite
 * @property string $created_date
 * @property string $updated_date

 */
class Faqfav extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq_favourite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_date', 'updated_date'], 'string'],
            [['user_id', 'faq_id'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['user_id', 'faq_id', 'isfavourite'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'faq_id' => 'Faq ID',
            'isfavourite' => 'isfavourite',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
        ];
    }
}
