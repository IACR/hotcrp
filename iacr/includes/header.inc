<?php
 global $Me;
 if (!$Me->is_signed_in()) {
   header("Location: ..");
 }
?>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>IACR functionality of hotcrp</title>
    <link href="https://iacr.org/libs/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../stylesheets/style.css" rel="stylesheet">
    <link href="../stylesheets/iacr.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://iacr.org/favicon.ico">
    <style>
     .leftnav {
       font-size: 75%;
       background-color:  #ecf2f4;
       padding: 20px 0px 10px 0px;          
     }
     .leftnav > div {
       margin-top: 6px;
       margin-bottom: 6px;
     }
     div.navheader {
       margin-top: 10px;
     }
     .leftnav a.navitem {
       border-radius: 5px;
       margin-left: 5px;
       color:black;
       text-decoration: none;
       padding: 5px 5px 5px 10px;
       border: 1px solid transparent;
     }
     .leftnav a.active {
       border: 1px solid red;
       color: red;
       background-color: white;
     }
     .leftnav a:hover {
       border: 1px solid green;
       color: green;
       background-color: white;
     }
    </style>
    <script src="https://iacr.org/libs/js/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://iacr.org/libs/css/bootstrap/dist/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div id="top">
      <div id="header-site">
        <a class="qq" href="/<?php echo $Opt['shortName'];?>/"><span class="header-site-name"><?php echo $Opt['shortName'];?></span></a>
      </div>
    <h2 class="float-right mt-4 mr-4">IACR hotcrp integration</h2>
    </div>
    
