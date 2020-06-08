let popupDiv = document.getElementById("exportSubscriptionPopup");
const popupRevealMS = 500;

function enablePopup(){
    console.log("2");
    popupDiv.style.display = 'flex';
}

function exportClicked(){
    setTimeout(enablePopup, popupRevealMS);
    console.log("1");
}