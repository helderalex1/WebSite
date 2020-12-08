<?php

namespace frontend\controllers;

use app\models\User;
use Yii;

class FriendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $role= Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->getId());

        if(isset($role['instalador'])){
            $fornecedores = Yii::$app->authManager->getUserIdsByRole('fornecedor');
            $count = 0;
            for($i=0; $i< count($fornecedores);$i++){
                $user = User::findOne($fornecedores[$i]);
                if($user != null && $user['status']==10){
                    $data[$count]=$user;
                    $count++;
                }
            }
            return $this->render('instalador',[
                'data' => $data
        ]);
        }else if(isset($role['fornecedor'])){
            echo 'aa';
        }else{

        }

    }

}
