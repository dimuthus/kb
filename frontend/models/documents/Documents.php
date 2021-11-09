<?php

namespace frontend\models\documents;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "service_request".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $service_request_id
 * @property integer $service_channel_type
 * @property integer $case_category_1
 * @property integer $case_category_2
 * @property integer $case_category_3
 * @property integer $service_case_status
 * @property integer $escalated_to
 * @property integer $priority
 * @property string $country
 * @property integer $service_center
 * @property integer $created_by
 * @property integer $closed_by
 * @property string $onsite_appointment_datetime
 * @property string $city
 * @property string $flight_route
 * @property string $station
 * @property string $creation_datetime
 * @property string $last_modified_datetime
 * @property string $closed_datetime
 * @property string $other_reason
 */
class Documents extends \yii\db\ActiveRecord
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
            [['description', 'category_id','original_filename'], 'required', 'message'=>'Mendatory Field(s)'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
           'category_id' => 'Category Name',
            'docCategory.name' => 'Category Name',
            'original_filename' => 'File Name',
            'totalbytes' => 'Size (Byte)',
            'uploaded_date' => 'Uploaded Date',
            'modify_date' => 'Modify Date',
            'description' => 'Description',
            'visited_count' => 'Visited Count',
            'acknowledge' => 'Acknowledge',
            'deleted' => 'Deleted',
        ];
       
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getDoccategory()
    {
        return $this->hasOne(DocCategory::className(), ['id' => 'category_id']);
    }
    
   /*
 * Return the decrypted value of the field (does NOT assign
 * the decrypted value back to the attribute)
 * @return string
 */
public function encryptString($stringValues)
{
  // Nothing to decrypt
  if ( $stringValues == '' )
    return '';
  $key="AHSANA-AL-RUPOM";
  return utf8_encode(Yii::$app->security->encryptByKey($stringValues, $key));
 // return Yii::$app->securityManager->encrypt($stringValues,"AHSAN-AL-RUPOM");
    
}
 
     /**
 * Return the decrypted value of the field (does NOT assign
 * the decrypted value back to the attribute)
 * @return string
 */
public function decryptString($stringValues)
{
  // Nothing to decrypt
  if ( $stringValues == '' )
    return '';
  $key="AHSANA-AL-RUPOM";
  return Yii::$app->security->decryptByKey(utf8_decode($stringValues), $key);
 // return Yii::$app->securityManager->encrypt($stringValues,"AHSAN-AL-RUPOM");
    
}

}
 