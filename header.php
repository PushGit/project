<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>companies.ru</title>
  <link rel="stylesheet"  href="bootstrap.css">
</head>
<body>
  
<div class='container' style='margin-top'>
  <div id="wrapper">


<div class='navbar navbar-inverse navbar-fixed-top'>
      <nav class='navbar-inner'>
        <a class='brand'>Companies.ru</a>
        <ul class='nav'>
          <li class='divider-vertical'></li>
          <li><a href='index.php'><i class='icon-home'></i>Главная</a></li>
          <li><a href='index.php?page=companies&action=view'>Компании</a></li>
        
          <li class='dropdown'>
            <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Продукты<b class='caret'></b></a>
            <ul class='dropdown-menu'>
              <li><a href='index.php?page=products&action=viewAll'>Показать все</a></li>
              <li><a href='index.php?page=companies&action=view'>По компаниям</a></li>
              <li><a href='index.php?page=products&action=view'>Наши продукты</a></li>
            </ul>
          </li>
         <script src='bootstrap.js'></script>
<script src='jquery.js'></script>
          <li class='dropdown'>
            <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Контакты<b class='caret'></b></a>
            <ul class='dropdown-menu'>
              <li><a href='#'>Написать e-mail</a></li>
              <li><a href='#'>Телефоны и факсы</a></li>
              <li><a href='#'>На карте</a></li>
            </ul>
          </li>
          <li><a href='#'>О нас</a></li>
        </ul>
        <form class='navbar-form pull-right' method=post action=index.php?page=main&action=login>
      <input type=text  required name=login placeholder='Login' id='search_box' value=>
      <input type=password required name=password placeholder='Password' id='search_box'>
      <button type=submit id='button_new' >Войти</button>
      <button type=submit id='button_new' >Зарегистрироваться</button>
      </form>
      </nav>
      </div>

    





</body>
 </html>

<?php /*\model\main::enter();
</div>";
/*

<div id="wrapper">до <div id="header">



 <div id="header_nav">
  <form method="GET" action="index.php">
    <ul>
      <li><a href="index.php"><i class="icon-home"></i> Главная</a></li>
      <li><a href="index.php?page=companies&action=view">Компании</a></li>
     <li><a href="index.php?page=companies&action=view">Продукты</a></li>
    </ul>
  </form>
  </div>

<div class='carousel slide' id='myCarousel'>
  <ol class='carousel-indicators'>
    <li class='active' data-target='#myCarousel' data-slide-to='0'></li>
    <li data-target='#myCarousel' data-slide-to='1'></li>
    <li data-target='#myCarousel' data-slide-to='2'></li>
  </ol>
  <div class='carousel-inner'>
    <div class='item active'>
      <img src='1.jpg'>
      <div class='carousel-caption'>
        <h4>Заголовок1</h4>
        <p>Текст описания</p>
      </div>
    </div>
    <div class='item'>
      <img src='2.jpg'>
      <div class='carousel-caption'>
        <h4>Заголовок2</h4>
        <p>Текст описания</p>
      </div>
    </div>
    <div class='item'>
      <img src='3.jpg'>
      <div class='carousel-caption'>
        <h4>Заголовок3</h4>
        <p>Текст описания</p>
      </div>
    </div>
</div>
<script src='bootstrap.js'></script>
<script src='jquery.js'></script>
<a class='carousel-control left' data-slide='prev' href='#myCarousel'>&lsaquo;</a>
<a class='carousel-control right' data-slide='next' href='#myCarousel'>&rsaquo;</a>
</div>
*/
?>
