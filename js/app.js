(function () {
    var app = angular.module('gemStore', []);

    app.controller('StoreController', ['$scope', '$http', function ($scope, $http) {
        $scope.amount = 0;
        $scope.cart = [];

        $scope.loggedIn = false;
        var user = getFromSession('user');
        console.log(user);
        var now = new Date();
        if (user != undefined) {
          var expiration = new Date(user.token_expiration);
          if (expiration > now) {
            $scope.loggedInUser=user;
            $scope.loggedIn = true;
          }
        }

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

        this.buy= function(){
            var cart = $scope.cart;
            var products ={};
            for(var j = 0; j < cart.length; j++){
                products[cart[j].id]=cart[j].amount;
            }
            jsonToSend={};
            jsonToSend.total = cart.length;
            jsonToSend.products=products;
            jsonToSend.token=user.token;
            $http({
                url: '/api/orders.php?action=create',
                method: "POST",
                headers:{'Content-Type':"application/json"},
                data:JSON.stringify(jsonToSend)
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
                $("#loginText").append("User has been added");
                $scope.data = data;
            }).error(function(data, status, headers, config) {
                $scope.status = status;
            });
        };
        $scope.login = function(user){
            $http({
                url: '/api/users.php?action=authenticate',
                method: "POST",
                headers:{'Content-Type':"application/json"},
                data:JSON.stringify(user)
            }).success(function(data, status, headers, config) {
                $scope.user = data.user;

                /**
                 * Save to sessionStorage
                 *
                 * To retrieve this information:
                 * $user = angular.fromJson(sessionStorage.user);
                 */
                sessionStorage.user = angular.toJson(data.user);
                $scope.loggedIn=true;
            }).error(function(data, status, headers, config) {
                $scope.status = status;
            });
        };

        $scope.logout = function(){
            var user = getFromSession('user');
            $http({
                url: '/api/users.php?action=remove_token',
                method: "POST",
                headers:{'Content-Type':"application/json"},
                data:JSON.stringify({'token': user.token})
            }).success(function(data, status, headers, config) {
                removeFromSession('user');
                $scope.loggedIn=false;
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

    app.directive("navBar", function() {
        return {
            restrict: 'E',
            templateUrl: "html/nav-bar.html"
        };
    });
    app.directive("cart", function() {
        return {
            restrict: 'E',
            templateUrl: "html/cart.html"
        };
    });
    app.directive("userInfoModal", function() {
        return {
            restrict: 'E',
            templateUrl: "html/user-info-modal.html"
        };
    });



})();
