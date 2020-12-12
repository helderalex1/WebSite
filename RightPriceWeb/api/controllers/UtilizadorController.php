<?php

namespace app\controllers;

use \frontend\models\SignupForm;
use \common\models\User;
use phpDocumentor\Reflection\Types\True_;
use Yii;
//use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * UtilizadorController implements the CRUD actions for Utilizador model.
 */
class UtilizadorController extends ActiveController
{
    public $modelClass = '\common\models\User';
    public $modelClassCategoria= 'app\models\Categoria';



    public function actionLogin($username, $password){
        $climodel = new $this->modelClass;

        $user = $climodel::find()->where(["username"=>$username])->one();

       if(!$user){
            return json_encode("username ou password invalida");
        }else if($user->status == 0 ){
           return json_encode("Voce foi bloqueado");
       }else if($user->status == 9  ){
           return json_encode("A espera da aprovacao dos admins");
       }else if($user->status == 10  ){
           $hash = $user->password_hash;
           if(Yii::$app->getSecurity()->validatePassword($password, $hash) == true  ){
                return json_encode(["id"=>$user->id,"nome"=>$user->nome, "nome_empresa"=>$user->nome_empresa,"telemovel"=>$user->telemovel,
                    "email"=>$user->email,"imagem"=>$user->imagem,"categoria_id"=>$user->categoria_id, "auth_key"=>$user->auth_key]);
            }else{
               return json_encode("username ou password invalida");
           }
        }
    }

    public function actionRegistar(){
        $climodel = new $this->modelClass;
        $categoriamodel = new $this->modelClassCategoria;
        $usernamene_exists=null;
        $emai_exists=null;
        $request = Yii::$app->request;
        if (!$request->isPost)
        {
            Yii::$app->response->statusCode = 400;
            die();
        }
            $user_request= $request->post();
            if(!isset($user_request["nome"]) || !isset($user_request["email"]) ||  !isset($user_request["password"]) || !isset($user_request["funcao"]) || !isset($user_request["categoria"])|| !isset($user_request["username"])){
                return json_encode("Preencha todos os campos");
            }else{
                $usernamene_exists = $climodel::find()->where(["username"=>$user_request["username"]])->one();
                $emai_exists = $climodel::find()->where(["email"=>$user_request["email"]])->one();
                if($usernamene_exists!=null){
                    return json_encode("Usename Ja utilizado");
                }else if ($emai_exists!=null){
                    return json_encode("Email ja utilizado");
                }else{
                    $Categoria= $categoriamodel::find()->where(["nome_Categoria"=>$user_request["categoria"]])->one();
                    $User= new User();
                    $User->nome = $user_request["nome"];
                    $User->username = $user_request["username"];
                    $User->email= $user_request["email"];
                    $User->setPassword($user_request["password"]);
                    $User->generateAuthKey();
                    $User->generateEmailVerificationToken();
                    $User->categoria_id= $Categoria->id;
                    if(!$User->save()){
                        return json_encode("Erro a fazer o registo. Tente mais tarde ou contacte os administrador");
                    }
                    $auth = \Yii::$app->authManager;
                    $authorRole = $auth->getRole($this->role);
                    $auth->assign($authorRole, $User->getId());
                    $SignupForm = new SignupForm();
                    $SignupForm->sendEmail($User);
                    return  json_encode("Conta registada com sucesso");

                }



            }



        // return $user["nome"];

     






    }
}