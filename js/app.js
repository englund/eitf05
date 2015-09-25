(function () {
    var app = angular.module('gemStore', []);

    app.controller('StoreController', ['$scope', '$http', function ($scope, $http) {
        $scope.amount = 0;
        $scope.cart = [];

        this.addToCart = function (product) {
            var cart = $scope.cart;
            var found = cart.some(function (el) {
                if (el.name === product.name) {
                    product.amount = 2;
                    return true;
                }
                return false;
            });
            if (!found) {
                $scope.cart.push(product);
            }
            amountOfValues();
        };
        var amountOfValues = function () {
            var count = 0;

            for (var items in $scope.cart) {
                count += items.amount;
            }
            $scope.ItemAmount = count;
        };
        $http.get('/api/products.php').success(function (response) {
            $scope.products = response.products;
        });


        $scope.signUp = function(user){
            console.log(JSON.stringify(user));
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
        }
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

    app.controller('GalleryController', function () {
        this.current = 0;

        this.setCurrent = function (imageNumber) {
            this.current = imageNumber || 0;
        };
    });

    app.controller("ReviewController", function () {

        this.review = {};

        this.addReview = function (product) {
            product.reviews.push(this.review);
            this.review = {};
        };
    });


})();
