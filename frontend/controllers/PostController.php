<?php
namespace frontend\controllers;
/*文章控制器*/
use Yii;
use frontend\controllers\base\Basecontroller;
use frontend\models\PostForm;
use common\models\CatModel;

class PostController extends Basecontroller
{
    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',    
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }
    /**
     *博客
     *文章列表 
     * 
      */
    public function  actionIndex()
    {
        return $this->render('index');
    }
    public  function  actionCreate()
    {
        $model =new PostForm();
        $model->setScenario(PostForm::SCENARIOS_CREATE);
        if(!$model->create()){
            Yii::$app->session->setFlash('warning',$model->_lastError);
        }else 
            {
             return $this->redirect(['post/view','id'=>$model->id]);   
            }
        $cat = CatModel::getAllCats();
        return $this->render('create',['model'=>$model,'cat'=>$cat]);
    }
}