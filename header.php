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
          <li><a href='http://companies.ru/'>Главная</a></li>
          <li><a href='index.php?page=companies&action=view'>Компании</a></li>
        
          <li class='dropdown'>
            <a href='index.php?page=products&action=viewAll' class='dropdown-toggle' data-toggle='dropdown'>Продукты<b class='caret'></b></a>
            <ul class='dropdown-menu'>
              <li><a href='index.php?page=products&action=viewAll'>Показать все</a></li>
              <li><a href='index.php?page=companies&action=view'>По компаниям</a></li>
 <?php
  if(@$_COOKIE['userID'] && @$_COOKIE['companyID'])
          {
              echo "<li><a href='index.php?page=products&action=view'>Наши продукты</a></li>";
          }
                ?>
            </ul>
          </li>
         <script src='bootstrap.js'></script>
          <script src='jquery.js'></script> 
          <script type='javascript' src="jquery.form.js"></script>
          <li><a href='index.php?page=products&action=viewPic'>Картинки</a></li>
          <?php
          if(@$_COOKIE['userID'])
          {
            $nameUser = $_COOKIE['log'];
              echo "
               <li><a href='#'>Привет, $nameUser</a></li>
               <li><a href='index.php?page=main&action=logout'>Выход</a></li>";
          }
          else {
           echo "
             <li><input type=text required name=login placeholder='Login' id='Login' value=></li>
              <li>&nbsp; <input type=password required name=password placeholder='Password' id='Password'></li>
              <li><a  href='#' onclick='login()' >Войти</a></li>
              <li><a href='index.php?page=main&action=reg'>Зарегистрироваться</a></li>
              <script>
              function login()
              {
                var Login = $('#Login').val();
                var Password = $('#Password').val();
                $.ajax({
                  type:'POST',
                  url:'index.php?page=main&action=login',
                  data:{login:Login,password:Password},
                  dataType:'html',
                  success:function(data)
                  {
                    document.location.href = 'http://companies.ru/';
                  }
                   });
              }
              </script>";
          }
          ?>
        </ul>
        
      </nav>
      </div>
      
    





</body>

 </html>

<?php

/*
<div id="wrapper">до <div id="header">

 \model\main::enter();
"</div>";

 <div id="header_nav">
  <form method="GET" action="index.php">
    <ul>
      <li><a href="index.php"><i class="icon-home"></i> Главная</a></li>
      <li><a href="index.php?page=companies&action=view">Компании</a></li>
     <li><a href="index.php?page=companies&action=view">Продукты</a></li>
    </ul>
  </form>
  </div>

<form class='navbar-form pull-right' method=post action=index.php?page=main&action=login>
      <input type=text  required name=login placeholder='Login' id='search_box' value=>
      <input type=password required name=password placeholder='Password' id='search_box'>
      <button type=submit id='button_new' >Войти</button>
      <button type=submit id='button_new' >Зарегистрироваться</button>
      </form>





<style>
.block2{
    height: 180px;
    background: #666;
  }
  </style>
    <body>
         
    <script src="js/bootstrap.js"></script>
    <script src='js/jquery.js'></script>
   <div class='container-fluid'>
     <div class='row'>
       
        
         <div class='span2 block2'></div>
         <div class='span2 block'></div>
         <div class='span2 block2'></div>
        
       </div></div>
     

  </body>







*/
?>
