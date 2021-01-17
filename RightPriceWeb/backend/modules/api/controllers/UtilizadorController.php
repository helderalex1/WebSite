<?php

namespace app\modules\api\controllers;

use common\models\AuthAssignment;
use common\models\User;
use Yii;
use yii\rest\ActiveController;


/**
 * UtilizadorController implements the CRUD actions for Utilizador model.
 */
class UtilizadorController extends ActiveController
{
    public $modelClass = 'common\models\User';
    public $modelClassCategoria= 'common\models\Categoria';
    public $modelClassFuncao = 'common\models\AuthAssignment';



// função para o login da aplicaçao
// serve para o login da aplicação android
    public function actionLogin($username, $password){
        $clientemodel = new $this->modelClass;
        $funcaomodel = new $this->modelClassFuncao;

        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do get method");
        }

        $user = $clientemodel::find()->where(["username"=>$username])->one();

       if(!$user){
            return ["sucesso"=>"false","texto"=>"Username ou password invalida"];
       }else if($user->status == 0 ){
           return ["sucesso"=>"false","texto"=>"Voce foi bloqueado"];
       }else if($user->status == 9  ){
           return ["sucesso"=>"false","texto"=>"A espera da aprovacao dos admins"];
       }else if($user->status == 10  ){
           $Funcao= $funcaomodel::find()->where(["user_id"=>$user->id])->one();
           $hash = $user->password_hash;
           if(Yii::$app->getSecurity()->validatePassword($password, $hash) == true  ){
                return ["sucesso"=>"true","id"=>$user->id,"username"=>$user->username,"nome"=>$user->nome, "nome_empresa"=>$user->nome_empresa,"telemovel"=>$user->telemovel, "email"=>$user->email,"imagem"=>$user->imagem,"categoria_id"=>$user->categoria_id, "auth_key"=>$user->auth_key , "funcao"=>$Funcao->item_name  ];
           }else{
               return ["sucesso"=>"false","texto"=>"Username ou password invalida"];
           }
       }
       return ["sucesso"=>"false","texto"=>"Erro ao fazer o login. Tente mais tarde ou contacte o suporte"];
    }

    //função para o registo da aplicação
    //serve para registar os utilizadores no android
    public function actionRegistar(){
        $clientemodel = new $this->modelClass;
        $categoriamodel = new $this->modelClassCategoria;


        $usernamene_exists=null;
        $emai_exists=null;

        $request = Yii::$app->request;
        if (!$request->isPost)
        {
            Yii::$app->response->statusCode = 400;
            throw new \yii\web\BadRequestHttpException("Error method you only have permissions to do post method");
        }

        $user_request= $request->post();

        if(!isset($user_request["nome"]) || !isset($user_request["email"]) ||  !isset($user_request["password"]) || !isset($user_request["funcao"]) || !isset($user_request["categoria"])|| !isset($user_request["username"])) {
            return ["sucesso"=>"false","texto"=>"Preencha todos os campos"];
        }else{
            $usernamene_exists = $clientemodel::find()->where(["username"=>$user_request["username"]])->one();
            $emai_exists = $clientemodel::find()->where(["email"=>$user_request["email"]])->one();
            if($usernamene_exists!=null){
                return ["sucesso"=>"false","texto"=>"Username Ja utilizado"];
            }else if ($emai_exists!=null){
                return ["sucesso"=>"false","texto"=>"Email ja utilizado"];
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
                    return ["sucesso"=>"false","texto"=>"Erro a fazer o registo. Tente mais tarde ou contacte o suporte"];
                }
                $userid= $clientemodel::find()->where(["username"=>$user_request["username"]])->one();
                $auth= new AuthAssignment();
                $auth->item_name = $user_request["funcao"];
                $auth->user_id= $userid->id;
                $auth->save(false);

                if (strcmp($user_request["funcao"],"fornecedor")==0){
                    $this->FazPublish("NovoCliente",json_encode("Tem um novo Fornecedor a aceitar. O cliente chama-se ".$User->nome."."));
                }else if (strcmp($user_request["funcao"],"instalador"==0)){
                    $this->FazPublish("NovoCliente",json_encode("Tem um novo instalador a aceitar. O cliente chama-se ".$User->nome."."));
                }else{
                    $this->FazPublish("NovoCliente",json_encode("Tem um novo cliente a aceitar. O cliente chama-se ".$User->nome."."));
                }
                return ["sucesso"=>"true","texto"=>"Conta registada com sucesso"];
            }
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


    //função que envia a menssagem do mosquitto no Tópico defeinido
    public function FazPublish($canal,$msg)
    {
        $server = "jpla-rpla.asuscomm.com";
        $port = 1883;
        $client_id = "phpMQTT-publisher"; // unique!
        $mqtt = new mosquitto\phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL))
        {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        }
        else { file_put_contents("debug.output","Time out!"); }
}

}