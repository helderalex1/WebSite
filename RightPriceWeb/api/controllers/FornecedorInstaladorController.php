<?php

namespace app\controllers;

use yii\db\Query;
use yii\rest\ActiveController;

/**
 * FornecedorInstaladorController implements the CRUD actions for FornecedorInstalador model.
 */
class FornecedorInstaladorController extends ActiveController
{
    public $modelClass = 'app\models\fornecedorinstalador';


    //Mostrar fornecedores da mesma categoria do instalador
    public function actionConhecerforne($id)
    {
        $query = new Query;
        $script = ($query
            ->select('u1.*')
            ->from('user u')
            ->innerJoin('fornecedor_instalador fi','fi.fornecedor_id = u.id')
            ->innerJoin('user u1','u1.id = fi.instalador_id ')
            ->where('u.id='.$id.' AND u.categoria_id <=> u1.categoria_id'))
            ->createCommand();
        $queryResult = $script->query();
        return $queryResult;
    }
    //Mostrar instaladores da mesma categoria do fornecedor
    public function actionConhecerinsta($id)
    {
        $query = new Query;
        $script = ($query
            ->select('u1.*')
            ->from('fornecedor_instalador fi')
            ->innerJoin('user u','u.id = fi.instalador_id ')
            ->innerJoin('user u1','fi.fornecedor_id = u1.id')
            ->where('u.id='.$id.' AND u.categoria_id <=> u1.categoria_id'))
            ->createCommand();
        $queryResult = $script->query();
        return $queryResult;
    }

    //Mostrar os instaladores desse fornecedor
    public function actionForne($id){
        $query = new Query;
        $script = ($query
            ->select('u1.*')
            ->from('user u')
            ->innerJoin('fornecedor_instalador fi','fi.fornecedor_id = u.id')
            ->innerJoin('user u1','u1.id = fi.instalador_id ')
            ->where('u.id='.$id))
            ->createCommand();
        $queryResult = $script->query();
        return $queryResult;

    //Mostrar os fornecedores desse isntalador
    }    public function actionInsta($id){
        $query = new \yii\db\Query;
        $script = ($query
            ->select('u1.*')
            ->from('fornecedor_instalador fi')
            ->innerJoin('user u','u.id = fi.instalador_id ')
            ->innerJoin('user u1','fi.fornecedor_id = u1.id')
            ->where('u.id='.$id))
            ->createCommand();
        $queryResult = $script->query();
        return $queryResult;
    }
}
