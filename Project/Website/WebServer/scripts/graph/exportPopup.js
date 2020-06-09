let popupDiv = document.getElementById("exportSubscriptionPopup");
const popupRevealMS = 500;
let emailTextInput = document.getElementById("subscriptionEmailInput");

function enablePopup(){
    console.log("2");
    popupDiv.style.display = 'flex';
}

function exportClicked(){
    setTimeout(enablePopup, popupRevealMS);
    console.log("1");
}

function closePopup(){
    console.log("3");
    popupDiv.style.display = 'none';
}



function subscribe(){
    // console.log(emailTextInput.value);
    let email = emailTextInput.value;
    if(email.includes('@')){
        let request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            // console.log(request.responseText);
            if(request.readyState === 4 && request.status === 200)
                // popupDiv.style.display = 'none';
                if(JSON.parse(request.responseText).status === 'SUCCESS')
                    popupDiv.style.display = 'none';
                // console.log(request.responseText);
            // else
                // console.log("failure");
        };

        request.open('POST', './../../addSubscription.php', true);
        // request.setRequestHeader('Access-Control-Allow-Origin', '*');
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send('email=' + email);
    }
}