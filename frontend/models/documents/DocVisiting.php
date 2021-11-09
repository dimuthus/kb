<?php

namespace frontend\models\documents;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $original_filename
 * @property integer $totalbytes
 * @property string $uploaded_date
 * @property string $modify_date
 * @property string $description
 * @property integer $visited_count
 * @property integer $acknowledge
 * @property integer $deleted
 */
class DocVisiting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $docRating;
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
            [['category_id', 'totalbytes', 'visited_count', 'acknowledge', 'deleted'], 'integer'],
            [['uploaded_date', 'modify_date'], 'safe'],
            [['acknowledge'], 'required'],
            [['original_filename', 'description'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'original_filename' => 'Document Name',
            'totalbytes' => 'Totalbytes',
            'uploaded_date' => 'Uploaded Date',
            'modify_date' => 'Modify Date',
            'description' => 'Description',
            'visited_count' => 'Visited Count',
            'acknowledge' => 'Acknowledge',
            'deleted' => 'Deleted',
            'docRating' => 'Rinking',
        ];
    }
    
    public function getDocumentsrating()
    { 
        return $this->hasOne(DocumentsRating::className(), ['doc_id' => 'id']);
    }
}
