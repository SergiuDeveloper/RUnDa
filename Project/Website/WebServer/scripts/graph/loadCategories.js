let selectCategory = document.getElementById("selectCategory");
let selectSubcategory = document.getElementById("selectSubcategory");
let selectLocation = document.getElementById("selectLocation");
let selectRegressionType = document.getElementById("selectRegressionType");

let URL = 'https://unemploymentpredictionapi.azurewebsites.net/RetrieveDataCategories';

let categories = [];
let subcategories = [];
let locations = [];
let regressions = [];

let predictionAppCategoriesJSON;
let predictionAppSubcategoriesJSON;
let predictionAppLocationsJSON;
let predictionAppRegressionsJSON;

function selectedSubcategory(){
    let subcategory = subcategories[selectSubcategory.selectedIndex];
    Object.keys(predictionAppSubcategoriesJSON).forEach(function (key) {
        if( key === subcategory )
            predictionAppLocationsJSON = predictionAppSubcategoriesJSON[key];
    });
    locations = populateSelect(selectLocation, predictionAppLocationsJSON, selectedLocation);
    selectedLocation();
}

function selectedRegression(){

}

function selectedLocation(){
    let location = locations[selectLocation.selectedIndex];

    regressions = []; let i = 0;

    Object.values(predictionAppLocationsJSON[location]).forEach(function (value) {
        regressions[i++] = value;
        let regression = document.createElement("option");
        regression.text = value.toString();
        selectRegressionType.add(regression);
    })
}

function populateSelect(selectElement, JSON, onSelectCallback){
    let i = 0;
    let categoryArray = [];

    Object.keys(JSON).forEach(function (key) {
        let category = document.createElement("option");
        categoryArray[i++] = key;
        category.text = key.toLowerCase().charAt(0).toUpperCase() + key.toLowerCase().slice(1);
        selectElement.add(category);
    })

    selectElement.addEventListener("change", onSelectCallback);

    return categoryArray;
}

function callbackPopulateCategory(response){
    predictionAppCategoriesJSON = JSON.parse(response).DataAttributes;

    categories = populateSelect(selectCategory, predictionAppCategoriesJSON, selectedCategory);
    selectedCategory();
}

function selectedCategory(){
    let category = categories[selectCategory.selectedIndex];
    Object.keys(predictionAppCategoriesJSON).forEach(function(key ) {
        if (key === category)
            predictionAppSubcategoriesJSON = predictionAppCategoriesJSON[key];
    });

    subcategories = populateSelect(selectSubcategory, predictionAppSubcategoriesJSON, selectedSubcategory);
    selectedSubcategory();
}


function errorCallbackDebug(state, status, response){
    console.log(state.toString());
    console.log(status.toString());
    console.log(response.toString());
}

function asyncCall(URL, callback){
    let httpRequest = new XMLHttpRequest();

    httpRequest.onreadystatechange = function () {
        if(httpRequest.readyState === 4 && httpRequest.status === 200)
            callback(httpRequest.responseText);
        else if (httpRequest.readyState === 4)
            errorCallbackDebug(httpRequest.readyState, httpRequest.status, httpRequest.responseText);
    }

    httpRequest.open("GET", URL,true);
    httpRequest.setRequestHeader('Access-Control-Allow-Origin', '*');
    httpRequest.send(null);
}

asyncCall(URL, callbackPopulateCategory);