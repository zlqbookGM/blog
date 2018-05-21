<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id 自增ID
 * @property string $title 标题
 * @property string $summary 摘要
 * @property string $content 内容
 * @property string $label_img 标签图
 * @property int $cat_id 分类id
 * @property int $user_id 用户id
 * @property string $user_name 用户名
 * @property int $is_valid 是否有效：0-未发布 1-已发布
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }
    /**定义场景*/
//    const SCENARIOS_CREATE = 'create';
//    const SCENARIOS_UPDATE = 'update';
//    const EVENT_AFTER_CREATE = "eventAfterCreate";
//    const EVENT_AFTER_UPDATE = "eventAfterUpdate";
    /**重写方法*/
    /*public function scenarios()
    {
        $scenarios =[
            self::SCENARIOS_CREATE=>['title','concent','label_img','cat_id','tags'],
            self::SCENARIOS_UPDATE=>['title','concent','label_img','cat_id','tags'],
        ];
        return array_merge(parent::scenarios(),$scenarios);
    }*/

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_id', 'user_id', 'is_valid'], 'integer'],
            [['title','content', 'summary', 'label_img', 'user_name'], 'string'],
            [[ 'created_at', 'updated_at'], 'safe']
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '文章ID',
            'title' => '标题',
            'summary' => '摘要',
            'content' => '内容',
            'label_img' => '缩略图',
            'cat_id' => '分类',
            'user_id' => 'User ID',
            'user_name' => '用户姓名',
            'is_valid' => 'Is Valid',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
    public function create()
    {
        //事务罗技
        $transaction = Yii::$app->db->beginTransaction();

        try{
            $model =new PostModel();
            $model->setAttributes($this->attributes);
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->created_at =time();
            $model->updated_at =time();
            if(!$model->save())
                throw new \Exception('保存失败！');
            $this->id = $model->id;
            //调用事件
            $data =array_merge($this->getAttributes(),$model->getAttributes());


            $transaction->commit();
            return true;

        }catch(\Exception $e){
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();
            return false;
        }
    }
}
