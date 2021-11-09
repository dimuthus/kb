<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $code
 * @property string $name
 * @property string $full_name
 * @property string $iso3
 * @property integer $number
 * @property string $continent_code
 * @property string $timezone
 * @property integer $enabled
 * @property integer $created_by
 * @property string $creation_datetime
 * @property string $last_modified_datetime
 * @property integer $deleted
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'enabled'], 'integer'],
            //[['creation_datetime', 'last_modified_datetime'], 'required'],
           
            [['name','full_name',], 'string', 'max' => 250],
            [['name','full_name'], 'required', 'message'=>'']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Value',
            'full_name' => 'Full Name',
            'iso3' => 'Iso3',
            'number' => 'Number',
            'continent_code' => 'Continent Code',
            'timezone' => 'Timezone',
            'enabled' => 'Status',
        ];
    }
}
