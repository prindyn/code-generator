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
            [['code_item', 'created_at'], 'required'],
            [['created_at'], 'safe'],
            [['code_item'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_item' => 'Code',
            'created_at' => 'Created date',
        ];
    }
}
