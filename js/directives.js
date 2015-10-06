(function(){
    var app = angular.module('store-directives', []);
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
