(function () {
    var app = angular.module('gemStore', []);

    app.controller('StoreController', function ($scope) {
        this.products = gems;
        $scope.amount=0;
        $scope.cart = [];

        this.addToCart = function (product) {
            var cart = $scope.cart;
            var found = cart.some(function (el) {
                if (el.name === product.name) {
                    console.log()
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
        }
    });

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

    app.controller('ServerCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.get = function() {
            console.log("sending a request");
            $http.get('/api/products.php').success(function(response) {
                console.log(response);
            });
        };
    }]);


    var gems = [{
        name: 'Azurite',
        amount: 1,
        description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
        shine: 8,
        price: 110.50,
        rarity: 7,
        color: '#CCC',
        faces: 14,
        images: []
    }, {
        name: 'Bloodstone',
        amount: 1,
        description: "Origin of the Bloodstone is unknown, hence its low value. It has a very high shine and 12 sides, however.",
        shine: 9,
        price: 22.90,
        rarity: 6,
        color: '#EEE',
        faces: 12,
        images: []
    },
        {
            name: 'Zircon',
            amount: 1,
            description: "Zircon is our most coveted and sought after gem. You will pay much to be the proud owner of this gorgeous and high shine gem.",
            shine: 70,
            price: 1100,
            rarity: 2,
            color: '#000',
            faces: 6,
            images: []
        }];


})();
