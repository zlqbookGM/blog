<?php
namespace frontend\controllers\base;
/*»ù´¡¿ØÖÆÆ÷*/
use yii\web\Controller;

class Basecontroller extends  Controller
{
    public  function beforeAction($action)
    {
        if(!parent::beforeAction($action))
        {
            return false;
        }
        else 
            return true;
    }
}