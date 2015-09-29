
//Chuncks an array
function chunk(arr, size) {
    var newArr = [];
    for (var i=0; i<arr.length; i+=size) {
        newArr.push(arr.slice(i, i+size));
    }
    return newArr;
}

function saveToSession(key, value) {
    sessionStorage[key] = angular.toJson(value);
}

function getFromSession(key) {
  return angular.fromJson(sessionStorage[key]);
}

function removeFromSession(key) {
  sessionStorage.removeItem(key);
}
