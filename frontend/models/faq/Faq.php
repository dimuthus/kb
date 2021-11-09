<?php

namespace frontend\models\faq;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property integer $id
 * @property string $category_name
 * @property string $sub_category_name
 * @property string $content_qestion
 * @property string $content_answer
 * @property string $created_date
 * @property integer $created_by
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_qestion', 'content_answer'], 'string'],
            [['content_qestion', 'content_answer','category_name','sub_category_name'], 'required'],
            [['created_date'], 'safe'],
            [['created_by','deleted'], 'integer'],
            [['category_name', 'sub_category_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'sub_category_name' => 'Sub Category Name',
            'content_qestion' => 'Content Qestion',
            'content_answer' => 'Content Answer',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'deleted' => 'Deleted',
        ];
    }
}
