<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>

    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('jquery-ui/jquery-ui.min.css') ?>
    <?= $this->Html->css('bootstrap-3.3.7/bootstrap.min.css') ?>
    <?= $this->Html->css('bootstrap-3.3.7/bootstrap-theme.min.css') ?>
    <?= $this->Html->css('styles.css') ?>
    <?= $this->Html->script('jquery/jquery-3.1.1.min.js') ?>
    <?= $this->Html->script('jquery/jquery-ui.min.js') ?>
    <?= $this->Html->script('jquery/jquery.color-2.1.2.min.js') ?>
    <?= $this->Html->script('plugins.js') ?>
    <?= $this->Html->script('bootstrap-3.3.7/bootstrap.min.js') ?>
    <?= $this->Html->script('ajax_helper'); ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="navbar navbar-default main-nav" id="main-nav">
        <div class="container-fluid container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" onclick="reset()">MovieServer</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li><a href="#" onclick="loadPage('<?= $this->Url->build(['controller' => 'Movies', 'action' => 'list']) ?>')">Movies</a></li>
                    <li><a href="#" onclick="loadPage('<?= $this->Url->build(['controller' => 'Search', 'action' => 'index'])?>')">Search</a></li>
                    <li><a href="#" onclick="loadPage('<?= $this->Url->build(['controller' => 'Download', 'action' => 'index'])?>')">Downloading</a></li>
                    <li><a href="#" onclick="loadPage('<?= $this->Url->build(['controller' => 'AdminTools', 'action' => 'index'])?>')">Admin Tools</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <canvas id="background"></canvas>
    <?= $this->Flash->render() ?>
    <div class="container" id="main-content">
        <?= $this->fetch('content') ?>
    </div>
    <script>
        $(function (){
            $('.main-nav a').click(function(){
                $('.main-nav').find('.active').removeClass('active');
                $(this).parent('li').addClass('active');
            });
        });
        $.when(pluginsLoaded).then(function() {
           $('#background').background();
        });
        function loadPage(url) {
            $('#main-content').fadeOut(400, function(){
                ajax_call(url, '', function (data){
                    $('#main-content').html(data).fadeIn(500);
                });
            });
            $('#main-nav').animate({top: "0"}, 500);
            return false;
        }

        function reset(){
            $('#main-nav').animate({top: "70%"}, 500);
            $('#main-content').fadeOut(250, function(){
                $('#main-content').html('');
            });
            return false;
        }
    </script>
</body>
</html>
