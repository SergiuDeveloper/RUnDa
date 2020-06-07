let selectCategory = document.getElementById("selectCategory");
let selectSubcategory = document.getElementById("selectSubcategory");
let selectLocation = document.getElementById("selectLocation");
let selectRegressionType = document.getElementById("selectRegressionType");

let URL = 'https://unemploymentpredictionapi.azurewebsites.net/RetrieveDataCategories';

let predictionAppCategoriesJSON;

function callbackPopulateCategory(response){
    predictionAppCategoriesJSON = JSON.parse(response).DataAttributes;
    let i = 0;

    Object.keys(predictionAppCategoriesJSON).forEach(function(key){
        // console.log(key);
        let category = document.createElement("option");
        category.text = key.toLowerCase().charAt(0).toUpperCase() + key.toLowerCase().slice(1);

        selectCategory.add(category);
    });

    selectCategory.addEventListener('change', function () {
        console.log(selectCategory.textContent);
    })
}

function selectedCategory(){
    console.log("a");
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