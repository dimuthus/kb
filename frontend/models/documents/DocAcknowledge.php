<?php

namespace frontend\models\documents;
use frontend\modules\tools\models\user\User;
use Yii;

/**
 * This is the model class for table "documents_acknowledge".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $doc_id
 * @property string $aknowledge_date
 */
class DocAcknowledge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documents_acknowledge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'doc_id'], 'required'],
            [['user_id', 'doc_id'], 'integer'],
            [['aknowledge_date','document','user','description'], 'safe']
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
            'aknowledge_date' => 'Aknowledge Date',
            'user.user' => 'User',
            'documents.original_filename' => 'File Name',
            'documents.description' => 'Document Description',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getDocuments()
    {
        return $this->hasOne(Documents::className(), ['id' => 'doc_id']);
    }
}
