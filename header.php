<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>companies.ru</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="wrapper">

<div id="header">
  <div id="header_nav">
  <form method="GET" action="index.php">
    <ul>
      <li><a href="index.php">Главная</a></li>
      <li><a href="index.php?page=companies&action=view">Компании</a></li>
    </ul>
  </form>
  </div>

<?php \model\main::enter();
echo "</div>";?>