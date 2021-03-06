(function () {
    var app = angular.module('gemStore', ['store-directives']);

    app.controller('StoreController', ['$scope', '$http', function ($scope, $http) {
        $scope.amount = 0;
        $scope.loggedIn = false;
        var user = getFromSession('user');
        console.log(user);
        creatCart();
        var now = new Date();
        if (user != undefined) {
          var expiration = new Date(user.token_expiration);
          if (expiration > now) {
            $scope.loggedInUser=user;
            $scope.loggedIn = true;
          }
        }
        function creatCart(){
            $scope.cart = {};
            $scope.cart.products = [];
            $scope.cart.totalPrice = 0;
        };
        this.addToCart = function (product,buy) {
            var cart = $scope.cart;
            var amount = buy.amount;
            buy.amount="";
            var found = cart.products.some(function (el) {
                if (el.name === product.name) {
                    product.amount += amount;
                    return true;
                }
                return false;
            });
            if (!found) {
                product.amount = amount;
                $scope.cart.products.push(product);
            }
            calculatePrice();
        };

        var calculatePrice = function () {
            var products = $scope.cart.products;
            var count = 0;
            for(var j = 0; j < products.length; j++){
                count+= products[j].amount* products[j].price;
            }
            $scope.cart.totalPrice = count;
        };

        $http.get('/api/products.php').success(function (response) {
            $scope.products = response.products;
            $scope.chunkedProducts = chunk(response.products, 3);
        });

        this.buy= function(){
            var cart = $scope.cart.products;
            var products ={};
            for(var j = 0; j < cart.length; j++){
                products[cart[j].id]=cart[j].amount;
            }
            jsonToSend={};
            jsonToSend.total = cart.length;
            jsonToSend.products=products;
            jsonToSend.token=user.token;
            console.log(JSON.stringify(jsonToSend));
            $http({
                url: '/api/orders.php?action=create',
                method: "POST",
                headers:{'Content-Type':"application/json"},
                data:JSON.stringify(jsonToSend)
            }).success(function(data, status, headers, config) {
                creatCart();
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
                alert(status);
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
                $scope.loggedInUser = data.user;

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
        $scope.loginHacking = function(user){
            $http({
                url: '/api/users.php?action=hackable_authenticate',
                method: "POST",
                headers:{'Content-Type':"application/json"},
                data:JSON.stringify(user)
            }).success(function(data, status, headers, config) {
                $scope.loggedInUser = data.user;

                var json_user = angular.toJson(data.user);
                sessionStorage.user = json_user;
                $.cookie('user_token', data.user.token);

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

})();
