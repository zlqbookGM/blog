<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/20/020
 * Time: 16:43
 */
namespace  backend\widgets\Postwidget;
use backend\models\PostForm;
use yii;
use yii\base\Widget;
use yii\base\Object;
use yii\helpers\Url;
use common\models\Posts;


class PostWidget extends Widget
{
    public $title = '';
    public $limit = 6;
    public $more = true;
    public $page =false;
    public function run()
    {   $curpage = Yii::$app->request->get('page',1);
        $cond = Posts::getlist($cond, $curpage,$this->limit);
        $result['title'] = $this ->title?:"最新文章";
        $result['more'] = Url::to(['backend/widgets/post/index']);

        if($this->page)
        {
            $pages =new  Pagination(['totalCount']);
        }
        return $this->render('index');
    }
}