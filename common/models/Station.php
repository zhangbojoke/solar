<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "station".
 *
 * @property int $id
 * @property int $installer 安装商
 * @property int $user
 * @property int $status 当前状态
 * @property int $created_at
 * @property string $location 所在经纬度
 * @property string $cell 电池组
 * @property string $inverter 逆变器
 * @property string $collector 采集器 
 * @property int $type 并网方式
 * @property string $title 标题
 * @property string $remark 备注
 * @property int $update_at 更新时间
 */
class Station extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'station';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['installer', 'user', 'location', 'cell', 'inverter', 'collector', 'title', 'remark'], 'required'],
            [['installer', 'user', 'status', 'type'], 'integer'],
            [['cell', 'inverter', 'collector'], 'string'],
            [['location'], 'string', 'max' => 60],
            [['title', 'remark'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'installer' => '所属安装商',
            'user' => '所属终端用户',
            'status' => '当前状态',
            'location' => '位置',
            'cell' => '电池',
            'inverter' => '逆变器',
            'collector' => '采集器',
            'type' => '并网类型',
            'title' => '电站名称',
            'remark' => '安装商备注',
            'created_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }

    public function getPeakPower(){
        return 0;
    }
}
