<?php

namespace frontend\models\documents;

use Yii;

/**
 * This is the model class for table "documents_rating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $doc_id
 * @property integer $rating
 * @property string $rating_date
 * @property string $rating_update
 */
class DocumentsRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documents_rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'doc_id', 'rating', 'rating_date'], 'required'],
            [['user_id', 'doc_id', 'rating'], 'integer'],
            [['rating_date', 'rating_update'], 'safe']
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
            'doc_id' => 'Doc ID',
            'rating' => 'Rating',
            'rating_date' => 'Rating Date',
            'rating_update' => 'Rating Update',
        ];
    }
}
