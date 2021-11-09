<?php

namespace frontend\models\documents;

use Yii;

/**
 * This is the model class for table "doc_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $deleted
 */
class DocCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doc_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deleted'], 'integer'],
            [['name', 'description'], 'string', 'max' => 250],
            [['name'], 'required', 'message'=>''],
            [['created_date'],'safe']
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
            'description' => 'Description',
            'deleted' => 'Status',
            'created_date'=>'Created Date',
        ];
    }
}
