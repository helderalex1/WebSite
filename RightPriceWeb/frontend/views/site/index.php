<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Right Price';


?>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>

        <div  class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="img/test.jpg" alt="Third slide">
                <div class="carousel-caption d-none d-md-block animated fadeInUp slow">
                    <h5 class="animated fadeInUp slow delay-1s">Espaços Comerciais</h5>
                    <p class="animated fadeInUp slow delay-2s">"Os nossos escritórios ficaram impecáveis quando terminados"</p>
                </div>

            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/slider2.png" alt="Second slide">
                <div class="carousel-caption d-none d-md-block animated fadeInUp slow">
                    <h5 class="animated fadeInUp slow delay-1s">Sistemas Industriais</h5>
                    <p class="animated fadeInUp slow delay-2s">"De uma forma simples e eficiente resolvemos grande parte dos problemas relacionados com o ambiente e condições de trabalho"</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/slider1.png" alt="First slide">
                <div class="carousel-caption d-none d-md-block  animated fadeInUp slow">
                    <h5 class="animated fadeInUp slow delay-1s">Climatização</h5>
                    <p class="animated fadeInUp slow delay-2s">"Notámos uma grande poupança no custo da energia após a instalação dos nossos sistemas."</p>
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

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>