<?php
namespace post_form;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use common\models\CatModel;
/* @var $this yii\web\View */
/* @var $model common\models\Posts */
/* @var $form yii\widgets\ActiveForm */

$cat = CatModel::getAllCats();
?>
<div class="row">
    <div class="col-lg-9">
<div class="posts-form">

    <?php $form = ActiveForm::begin(['id'=>'page-form']); ?>
    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cat_id')->dropDownList($cat) ?>

    <?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
        'config'=>[

        ]
    ]) ?>
    /**
    文章编辑器
    */
    <?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
        'options'=>[
            'initialFrameWidth' => 850,
            'initialFrameHeight'=>400,
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
    </div>
    <div class="col-lg-3">
        <div class="pannel-title box-title">
            <span>注意事项</span>
        </div>
        <div></div>
        <div class="pannel-body">
            <p>1.测试事项</p>
            <p>2.测试事项</p>
        </div>
    </div>
</div>