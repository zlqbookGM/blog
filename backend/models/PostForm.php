<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use yii\db\Transaction;
use common\models\PostModel;


class PostForm extends Model
{
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;
    
    public  $_lastError =""; 
    /**错误日志*/
    /**
     * 定义场景
     * 更新场景
     * */
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';
    const EVENT_AFTER_CREATE = "eventAfterCreate";
    const EVENT_AFTER_UPDATE = "eventAfterUpdate";
    /**
     * 场景设置
     * {@inheritDoc}
     * @see \yii\base\Model::scenarios()
     */
    public function scenarios()
    {
        $scenarios =[
          self::SCENARIOS_CREATE=>['title','concent','label_img','cat_id','tags'],
          self::SCENARIOS_UPDATE=>['title','concent','label_img','cat_id','tags'],
        ];
        return array_merge(parent::scenarios(),$scenarios);
    }
    public function rules()
    {
        return 
        [
            [['id','title','content','cat_id'],'required'],
            [['id','cat_id'],'integer'],
            ['title','string','min'=>4,'max'=>50],
        ];
    }
    public function attributeLabels()
    {
        return[
            'id'=>'编码',
            'title'=>'标题',
            'content'=>'内容',
            'label_img'=>'标签图',
            'cat_id'=>'分类',
            'tags'=>'标签',
        ];
    }
    /**
     * 创建文章创建
     * @throws \Exception
     * @return boolean
     */
    public function create()
    {
        //事务罗技
        $transaction = Yii::$app->db->beginTransaction();
       
        try{
            $model =new PostModel();
            $model->setAttributes($this->attributes);
            $model->summary =$this->_getSummary();
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->created_at =time();
            $model->updated_at =time();
            if(!$model->save())
                throw new \Exception('保存失败！');
                $this->id = $model->id;
               //调用事件
               $data =array_merge($this->getAttributes(),$model->getAttributes());
               $this->_eventAfterCreate($data);
               
            $transaction->commit();
            return true;
            
        }catch(\Exception $e){
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();
            return false;
        }
    }
    
    public function _getSummary($s =0 ,$e = 90, $char ='utf-8')
    {
        if(empty($this->content))
            return null;
        return (mb_substr(str_replace('&nbsp;',strip_tags($this->content)), $s,$e,$char));
        
    }
    
    public function _eventAfterCreate($data)
    {
        $this->on(self::EVENT_AFTER_CREATE,[$this,'_eventAddtag',$data]);
    }
    
    
}