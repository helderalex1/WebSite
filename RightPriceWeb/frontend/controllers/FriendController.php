<?php

namespace frontend\controllers;

use common\models\FornecedorInstalador;
use common\models\User;
use Yii;

class FriendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $role= Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->getId());
        $user = User::findOne(Yii::$app->user->identity->getId());
        $data = [];
        if(isset($role['instalador'])){
            $fornecedores = Yii::$app->authManager->getUserIdsByRole('fornecedor');
            $count = 0;
            for($i=0; $i< count($fornecedores);$i++){
                $fornecedor = User::findOne($fornecedores[$i]);
                //valida se o utilizador esta disponivel
                if($fornecedor != null && $fornecedor['status']==10){
                    //valida se o fornecedor ja nao esta adicionado
                    $fornecedores_adicionados = $user->getFornecedors()->asArray()->all();
                    $flag =true;
                    foreach ($fornecedores_adicionados as $forn){
                        if($forn['id'] ==$fornecedor['id']){
                            $flag = false;
                        }
                    }
                    if($flag){
                        $data[$count]=$fornecedor;
                        $count++;
                    }
                }
            }
            return $this->render('instalador',[
                'data' => $data
        ]);
        }else if(isset($role['fornecedor'])){
            $user = User::findOne(Yii::$app->user->identity->getId());
            return $this->render('fornecedor',[
                'data' => $user->getInstaladors()->asArray()->all()
            ]);
        }else{

        }

    }

    public function actionAddfriend($id){
        $novoFriend = new FornecedorInstalador();
        $novoFriend->fornecedor_id = $id;
        $novoFriend->instalador_id = Yii::$app->user->identity->getId();
        $novoFriend->save();
        return $this->redirect(['friend/index']);
    }

    public function actionRemovefriend($id){
        $novoFriend = FornecedorInstalador::findOne($id);
        $novoFriend->delete();
        return $this->redirect(['friend/view']);
    }

    public function actionView(){
        $user = User::findOne(Yii::$app->user->identity->getId());
        return $this->render('view',[
            'data' => $user->getFornecedors()->asArray()->all()
        ]);
    }

}
