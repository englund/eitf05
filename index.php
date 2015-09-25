<!DOCTYPE html>
<html ng-app="gemStore">
<head>
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
</head>

<body ng-controller="StoreController as store">
<!--header-->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a class="page-scroll" href="#signUp" data-toggle="modal" data-target="#signUp">Sign Up</a>
        </li>
        <li>
            <a class="page-scroll" href="#myModal" data-toggle="modal" data-target="#login">Login</a>
        </li>
        <li>
            <a class="page-scroll" href="#contact">Cart <span class="glyphicon glyphicon-shopping-cart"
                                                              aria-hidden="true"></span>{{cart.length}}{{ItemAmount}}</a>
        </li>
    </ul>
</div>
<!--  Store Header  -->
<header>
    <h1 class="text-center">Frukt och Grönt</h1>
</header>


<div class="col-md-4" ng-repeat="product in products">
    <h3>{{product.name}} <em class="pull-right">{{product.price | currency}}</em></h3>
    <!-- Image Gallery-->
    <div ng-controller="GalleryController as gallery" ng-show="product.images.length">
        <div class="img-wrap">
            <img ng-src="{{product.images[gallery.current]}}"/>
        </div>
        <ul class="img-thumbnails clearfix">
            <li class="small-image pull-left thumbnail" ng-repeat="image in product.images">
                <img ng-src="{{image}}"/>
            </li>
        </ul>
    </div>

    <input type="number" value="0" ng-model="amount">
    <input type="button" value="Buy" ng-click="store.addToCart(product)">
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="login" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Loggin</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" ng-model="user.username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" ng-model="user.password">
                    </div>
                    <button type="submit" class="btn btn-default" ng-click="login(user)">Login</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="signUp" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Loggin</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control" ng-model="user.username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" class="form-control" ng-model="user.password">
                    </div>
                    <div class="form-group">
                        <label for="address">Adress</label>
                        <input type="text"id="address" class="form-control" ng-model="user.address">
                    </div>
                    <button type="submit" class="btn btn-default" ng-click="signUp(user)">Sing up</button>

            </div>
        </div>
    </div>

</div>


</body>
</html>