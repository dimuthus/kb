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
class DocFeedback extends \yii\db\ActiveRecord
{

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documents_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           // 'id' => 'ID',
           // 'category_id' => 'Category Name',
            'user_id' => 'User Id',
            'doc_id' => 'Doc Id',
            'aknowledge_date' => 'Acknowledge Date',
            
        ];
       
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   

}
 