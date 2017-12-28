<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_extends".
 *
 * @property int $id 用户ID主键关联
 * @property string $company
 * @property string $identity
 * @property string $brand 品牌信息
 * @property string $mobile 联系电话
 * @property string $logo logo地址
 * @property string $license 营业执照
 */
class UserExtends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_extends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['company'], 'string', 'max' => 255],
            [['identity'], 'string', 'max' => 32],
            [['brand'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 11],
            [['logo', 'license'], 'string', 'max' => 80],
            [['id'], 'unique'],
            [['company'], 'unique'],
            [['identity'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company' => 'Company',
            'identity' => 'Identity',
            'brand' => 'Brand',
            'mobile' => 'Mobile',
            'logo' => 'Logo',
            'license' => 'License',
        ];
    }
}
