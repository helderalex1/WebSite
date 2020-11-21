<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/fontawesome/all.css" rel="stylesheet">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="/css/site.css">

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    if (Yii::$app->user->isGuest) {
        $brand =  [
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-expand-md navbar-light bg-light',
            ],
        ];
        $menuItems = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
        ];
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $role = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->getId());
        if(isset($role['fornecedor'])){
            $brand =  [
                'brandLabel' => Yii::$app->name,
                'brandUrl' => '/user',
                'options' => [
                    'class' => 'navbar-expand-md navbar-light bg-light',
                ],
            ];
            $menuItems[] = ['label' => 'Produtos', 'url' => ['/site/signup']];
            $menuItems[] = ['label' => 'Instaladores', 'url' => ['/friend']];
        }else if(isset($role['instalador'])){
            $brand =  [
                'brandLabel' => Yii::$app->name,
                'brandUrl' => '/user',
                'options' => [
                    'class' => 'navbar-expand-md navbar-light bg-light',
                ],
            ];
            $menuItems[] = ['label' => 'Clientes', 'url' => ['/cliente']];
            $menuItems[] = ['label' => 'Fornecedores', 'url' => ['/friend']];
        }
        $menuItems[] = ['label' => ''. ucfirst(Yii::$app->user->identity->username).'' , 'url' => ['/user/view', 'id' => Yii::$app->user->identity->getId()]];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout ',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }


    NavBar::begin($brand);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="container mt-5">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
