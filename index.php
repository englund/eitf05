<!DOCTYPE html>
<html ng-app="gemStore">
<head>
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/store.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
</head>

<body ng-controller="StoreController as store">

<nav class="navbar">
    <div class="container-fluid">
        <div>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="page-scroll" href="#signUp" data-toggle="modal" data-target="#signUp">Sign Up</a></li>
                <li><a class="page-scroll" href="#myModal" data-toggle="modal" data-target="#login">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
<header>
    <h2 class="text-center">Frukt och Grönt</h2>
</header>
<div class="container">
<div class="row">
    <div class="col-sm-3 col-lg-3 col-md-3">
        <div class="panel panel-default ">
            <div class="panel-heading">Cart <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
               <p class ="text-left">Price: {{totalPrice| currency}}</p>
            </div>
            <div class="panel-body">
                <ul class="list-group" ng-repeat="product in cart">
                    <li class="list-group-item">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>{{product.name}}</td>
                                <td>{{product.amount}}kg</td>
                                <td>{{product.price*product.amount| currency}}</td>
                            </tr>
                            </tbody>

                        </table>
                    </li>
                </ul>


            </div>
        </div>
    </div>
    <div class="col-sm-9 col-lg-9 col-md-9 scrollit">
        <product-information></product-information>
    </div>
</div>
</div>
<sing-up-modal></sing-up-modal>
<login-modal></login-modal>


</body>
</html>