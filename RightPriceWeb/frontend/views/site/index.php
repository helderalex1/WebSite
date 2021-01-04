<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Right Price';


?>
<div class="row section">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>

        <div  class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="/img/banner1.png" alt="Third slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="/img/banner2.jpg" alt="Second slide">
                <div class="carousel-caption d-none d-md-block animated fadeInUp slow">
                    <h5 class="animated fadeInUp slow delay-1s">Sistema Cloud</h5>
                    <p class="animated fadeInUp slow delay-2s">Deixe todas as preocupaçoes e atualizações para nós! Com o nosso sistema Cloud pode focar-se inteiramente no seu negócio.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="/img/banner3.jpg" alt="First slide">
                <div class="carousel-caption d-none d-md-block  animated fadeInUp slow">
                    <h5 class="animated fadeInUp slow delay-1s">Orçamentação</h5>
                    <p class="animated fadeInUp slow delay-2s">O nosso sistema de orçamentação permite entregar ao seu cliente um orçamento em breves momentos.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<div class="row section">
    <img class="d-block w-100" src="/img/mission.png" alt="mission">
</div>
<div class="row m-5">
    <h1>A NOSSA EQUIPA</h1>
</div>
<div class="row section">
    <div class="col-lg-4">
        <img class="rounded-circle mb-4" src="/img/marcos.jpg" alt="Generic placeholder image" width="180" height="180">
        <h2>Marcos Ferreira</h2>
        <p>Web Developer</p>
        <p>"If you think that you have reached perfection know that you still have much to learn"</p>
        <p><a class="btn btn-secondary" href="#" role="button">Linkedin &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
        <img class="rounded-circle mb-4" src="/img/rui.jpg" alt="Generic placeholder image" width="180" height="180">
        <h2>Rui Agostinho</h2>
        <p>Mobile Developer</p>
        <p>"If the journey is difficult, it is because you're on the right path "</p>
        <p><a class="btn btn-secondary" href="#" role="button">Linkedin &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
        <img class="rounded-circle mb-4" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="180" height="180">
        <h2>Hélder Abrantes</h2>
        <p>Project Manager</p>
        <p><a class="btn btn-secondary" href="#" role="button">Linkedin &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
</div>
<div class="row m-5">
    <h1>OS NOSSOS PARCEIROS</h1>
</div>


<div class="row section">
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <img class="card-img-top" src="/img/parceiro.png" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-text">Instalador 1</h2>
                <p class="card-text">Categoria</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <img class="card-img-top" src="/img/parceiro.png" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-text">Fornecedor 1</h2>
                <p class="card-text">Categoria</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <img class="card-img-top" src="/img/parceiro.png" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-text">Instalador 2</h2>
                <p class="card-text">Categoria</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <img class="card-img-top" src="/img/parceiro.png" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-text">Instalador 3</h2>
                <p class="card-text">Categoria</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <img class="card-img-top" src="/img/parceiro.png" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-text">Fornecedor 2</h2>
                <p class="card-text">Categoria</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <img class="card-img-top" src="/img/parceiro.png" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-text">Instalador 4</h2>
                <p class="card-text">Categoria</p>
            </div>
        </div>
    </div>
</div>
