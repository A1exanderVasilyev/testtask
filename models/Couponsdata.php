<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "couponsdata".
 *
 * @property int $id
 * @property int|null $shop_id
 * @property string|null $title
 * @property string|null $content
 * @property string|null $ends_at
 */
class Couponsdata extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'couponsdata';
    }

    public static function insCoupData($shop_id, $title, $content, $ends_at)
    {
        Yii::$app->db->createCommand()->insert('couponsdata', [
            'shop_id' => $shop_id,
            'title' => $title,
            'content' => $content,
            'ends_at' => $ends_at,
        ])->execute();
    }

    public static function clearTable()
    {
        $clearTable = Yii::$app->db->createCommand()->truncateTable('couponsdata')->execute();
        return $clearTable;
    }
}
