<!DOCTYPE html>
<html ng-app="gemStore">
<head>
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/angular.min.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
</head>

<body ng-controller="StoreController as store">
<!--header-->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
        <li class="hidden active">
            <a href="#page-top"></a>
        </li>
        <li>
            <a class="page-scroll" href="#services">Login</a>
        </li>
        <li>
            <a class="page-scroll" href="#contact">Cart <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>{{cart.length}}{{ItemAmount}}</a>
        </li>
    </ul>
</div>
<!--  Store Header  -->
<header>
    <h1 class="text-center">Frukt och Grönt</h1>
</header>


<div class="col-md-4" ng-repeat="product in store.products">
    <h3>{{product.name}} <em class="pull-right">{{product.price | currency}}</em></h3>
    <!-- Image Gallery  -->
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
</body>
</html>