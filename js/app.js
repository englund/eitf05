(function () {
    var app = angular.module('gemStore', []);

    app.controller('StoreController', ['$scope', '$http', function ($scope, $http) {
        $scope.amount = 0;
        $scope.cart = [];

        this.addToCart = function (product,buy) {
            var cart = $scope.cart;
            var amount = buy.amount;
            buy.amount="";
            var found = cart.some(function (el) {
                if (el.name === product.name) {
                    product.amount += amount;
                    return true;
                }
                return false;
            });
            if (!found) {
                product.amount = amount;
                $scope.cart.push(product);
            }
            calculatePrice();
        };

        var calculatePrice = function () {
            var cart = $scope.cart;
            var count = 0;
            for(var j = 0; j < cart.length; j++){
                count+= cart[j].amount* cart[j].price;
            }
            $scope.totalPrice = count;
        };
        $http.get('/api/products.php').success(function (response) {
            $scope.products = response.products;
            $scope.chunkedProducts = chunk(response.products, 3);
        });

        $scope.buy= function(){
            var cart = $scope.cart;
            $http({
                url: '/api/users.php?action=create',
                method: "POST",
                headers:{'Content-Type':"application/json"},
                data:JSON.stringify(cart)
            }).success(function(data, status, headers, config) {
                $scope.data = data;
            }).error(function(data, status, headers, config) {
                $scope.status = status;
            });
        };
        $scope.signUp = function(user){
            $scope.username = user.username;
            $http({
                url: '/api/users.php?action=create',
                method: "POST",
                headers:{'Content-Type':"application/json"},
                data:JSON.stringify(user)
            }).success(function(data, status, headers, config) {
                $scope.data = data;
            }).error(function(data, status, headers, config) {
                $scope.status = status;
            });
        };
        $scope.login = function(user){
            $http({
                url: '/api/users.php?action=login',
                method: "POST",
                headers:{'Content-Type':"application/json"},
                data:JSON.stringify(user)
            }).success(function(data, status, headers, config) {
                $scope.data = data;
            }).error(function(data, status, headers, config) {
                $scope.status = status;
            });
        };
    }]);

    app.controller("TabController", function () {
        this.tab = 1;

        this.isSet = function (checkTab) {
            return this.tab === checkTab;
        };

        this.setTab = function (setTab) {
            this.tab = setTab;
        };
    });


    app.controller("ReviewController", function () {

        this.review = {};

        this.addReview = function (product) {
            product.reviews.push(this.review);
            this.review = {};
        };
    });

    app.directive("productInformation", function() {
        return {
            restrict: 'E',
            templateUrl: "html/product-layout.html"
        };
    });
    app.directive("singUpModal", function() {
        return {
            restrict: 'E',
            templateUrl: "html/sign-up-modal.html"
        };
    });
    app.directive("loginModal", function() {
        return {
            restrict: 'E',
            templateUrl: "html/login-modal.html"
        };
    });



})();
