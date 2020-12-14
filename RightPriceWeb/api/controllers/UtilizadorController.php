<?php

namespace app\controllers;

use app\models\AuthAssignment;
use RightpriceWeb\frontend\models\SignupForm;
use phpDocumentor\Reflection\Types\This;
use phpDocumentor\Reflection\Types\True_;
use Yii;
use app\models\User;
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
    public $modelClass = 'app\models\User';
    public $modelClassCategoria= 'app\models\Categoria';
    public $modelClassFuncao = 'app\models\AuthAssignment';



// função para o login da aplicaçao
    public function actionLogin($username, $password){
        $climodel = new $this->modelClass;
        $funcaomodel = new $this->modelClassFuncao;

        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            die();
        }

        $user = $climodel::find()->where(["username"=>$username])->one();

       if(!$user){
            return json_encode("username ou password invalida");
        }else if($user->status == 0 ){
           return json_encode("Voce foi bloqueado");
       }else if($user->status == 9  ){
           return json_encode("A espera da aprovacao dos admins");
       }else if($user->status == 10  ){
           $Funcao= $funcaomodel::find()->where(["user_id"=>$user->id])->one();
           $hash = $user->password_hash;
           if(Yii::$app->getSecurity()->validatePassword($password, $hash) == true  ){
                return json_encode(["id"=>$user->id,"nome"=>$user->nome, "nome_empresa"=>$user->nome_empresa,"telemovel"=>$user->telemovel,
                    "email"=>$user->email,"imagem"=>$user->imagem,"categoria_id"=>$user->categoria_id, "auth_key"=>$user->auth_key , "funcao"=>$Funcao->item_name  ]);
            }else{
               return json_encode("username ou password invalida");
           }
        }
    }

    //função para o registo da aplicação
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

        if(!isset($user_request["nome"]) || !isset($user_request["email"]) ||  !isset($user_request["password"]) || !isset($user_request["funcao"]) || !isset($user_request["categoria"])|| !isset($user_request["username"])) {
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
                $User->password_hash = $this->setPassword($user_request["password"]);
                $User->auth_key=$this->generateAuthKey();
                $User->verification_token=$this->generateEmailVerificationToken();
                $User->categoria_id= $Categoria->id;
                $User->status = 9;
                if(!$User->save(false)){
                    return json_encode("Erro a fazer o registo. Tente mais tarde ou contacte os administrador");
                }
                $userid= $climodel::find()->where(["username"=>$user_request["username"]])->one();
                $auth= new AuthAssignment();
                $auth->item_name = $user_request["funcao"];
                $auth->user_id= $userid->id;
                $auth->save(false);

                return  json_encode("Conta registada com sucesso");
                }
            return json_encode("Erro a registar utilizador. Tente mais tarde ou entre em contacto com os administradores");
        }

    }


  // funçoes que codificão a password e que gerão autthkey para colocar na base de dados
    public function setPassword($password)
    {
       return $password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
       return $auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateEmailVerificationToken()
    {
       return $verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


}