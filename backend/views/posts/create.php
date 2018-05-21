<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Posts */

$this->title = '创建文章';
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        var_dump()
    ]) ?>

</div>
