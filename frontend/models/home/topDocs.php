<?php

namespace frontend\models\home;

use Yii;

/**
 * This is the model class for table "home".
 *
 * @property integer $id
 * @property string $name
 */
class TopDocs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 12],
            [['name'], 'required', 'message'=>'Mendatory Field(s)'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
