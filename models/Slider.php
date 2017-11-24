<?php

/**
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use libs\Cache;

/**
 * Slider model.
 *
 * Initialy generated by gii.
 *
 * @author Muhammad Febriansyah <hifebriansyah@gmail.com>
 *
 * @since Class available since Release 1.0.0
 */
class Slider extends MainModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sliders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'image_url'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['status_id'], 'integer'],
            [['title', 'content'], 'string', 'max' => 80],
            [['image_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * Fetch all available data.
     *
     * If exist get from cache,
     * if no get from db,
     * then cache it.
     *
     * @return array
     *
     * @since Method available since Release 1.0.0
     */
    public static function fetchAll()
    {
        if(!Cache::redis()->exists(self::tableName())){
            $results = self::find()
                ->select(['id', 'title', 'content', 'image_url'])
                ->where(['status_id' => self::STATUS_ACTIVE])
                ->orderBy('id')
                ->asArray()
                ->all();

            Cache::setArray(self::tableName(), $results);
        }else{
            $results = Cache::getArray(self::tableName());
        }

        return $results;
    }
}