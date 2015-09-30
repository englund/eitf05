<!DOCTYPE html>
<html ng-app="gemStore">
<head>
    <meta charset="utf-8">
    <link href="libraries/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="libraries/jquery.min.js"></script>
    <script type="text/javascript" src="libraries/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
    <link href="css/store.css" rel="stylesheet" type="text/css">
</head>

<body ng-controller="StoreController as store">

<nav-bar></nav-bar>
<a href ="hackingWeb/hacking.html">Hacking Site</a>
<div class="container">
    <div class="row">
        <div class="col-sm-3 col-lg-3 col-md-3">
        <cart></cart>
        </div>
        <div class="col-sm-9 col-lg-9 col-md-9 scrollit">
            <product-information></product-information>
        </div>
    </div>
</div>
<sing-up-modal></sing-up-modal>
<user-info-modal></user-info-modal>


</body>
</html>