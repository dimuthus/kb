<?php

namespace frontend\models\faq;

use Yii;

/**
 * This is the model class for table "faqs_log".
 *
 * @property integer $id
 * @property string $file_name
 * @property string $date_created
 * @property integer $created_by
 */
class FaqsLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faqs_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_created'], 'safe'],
            [['created_by'], 'integer'],
            [['file_name','current_fileName'], 'string', 'max' => 255],
            [['file_name'], 'required'],
            [['file_name'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'date_created' => 'Date Created',
            'created_by' => 'Created By',
            'current_fileName' => 'Current File Name',
        ];
    }
}
