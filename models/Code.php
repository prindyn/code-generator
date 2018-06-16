<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Code".
 *
 * @property int $id
 * @property string $code_item
 * @property string $created_at
 */
class Code extends \yii\db\ActiveRecord
{
    public $delete;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Code';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code_item'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_item' => 'Codes',
            'created_at' => 'Created date',
        ];
    }
}
