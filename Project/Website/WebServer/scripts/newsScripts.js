let newsContainer = document.getElementById("newsContainer");


function generateNewsItem(ID, title, content){
    let itemContainer = document.createElement("div");
    itemContainer.className = "newsItem";
    itemContainer.id = ID;

    let deleteButton = document.createElement('button');
    deleteButton.innerText = 'X';
    deleteButton.className = 'hiddenDeleteButton';
    deleteButton.value = ID;
    deleteButton.addEventListener('click',deletePost);

    let titleText = document.createElement("h3");
    titleText.innerText = escapeHTML(title);

    let contentText = document.createElement("p");
    contentText.innerText = escapeHTML(content);

    itemContainer.appendChild(deleteButton);
    itemContainer.appendChild(titleText);
    itemContainer.appendChild(contentText);

    newsContainer.appendChild(itemContainer);
}

function escapeHTML(unsafeText) {
    let div = document.createElement('div');
    div.innerText = unsafeText;
    return div.innerHTML;
}

function retrieveNewsEntries(responseJSON){
    newsContainer.innerText = '';

    Object.values(responseJSON).forEach(function (value) {
        generateNewsItem(value.ID, value.title, value.content);
    })

    checkAdminToken();
}

function requestAsync(URL, callback){
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if(request.readyState === 4 && request.status === 200){
            let responseJSON = JSON.parse(request.responseText);
            if(responseJSON.status === 'SUCCESS')
                callback(responseJSON.content);
        }
    }
    request.open('GET', URL);
    request.send(null);
}

requestAsync('./getNews.php', retrieveNewsEntries);

// let adminToken = false;

function checkAdminToken() {
    console.log(adminToken);
    if(adminToken)
        modifyPageElements();
    else
        hideAdminElements();
}

function authenticateAdmin() {
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if(request.readyState === 4 && request.status === 200){
            console.log(request.responseText);
            if(JSON.parse(request.responseText).status === 'SUCCESS') {
                adminToken = true;
                updateAdminSession();
                modifyPageElements();
            }
            // console.log(adminToken);
        }
    }
    request.open('POST', './adminControl.php');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(
        'email=' +
        encodeURIComponent(document.getElementById("adminEmailInput").value) +
        '&token=' +
        encodeURIComponent(document.getElementById("adminPasswordInput").value)
    );
}

function modifyPageElements() {
    document.getElementById("adminMenuDiv").style.display = 'none';

    console.log(document.getElementsByClassName('hiddenDeleteButton'));

    let buttons = document.getElementsByClassName('hiddenDeleteButton');

    for(let i = 0; i < buttons.length; i++) {
        buttons[i].style.display = 'flex';
    }

    document.getElementById('logoutButton').style.display = 'flow';

    console.log('SHOW');
}

function hideAdminElements() {
    document.getElementById('adminMenuDiv').style.display = 'flow';

    let buttons = document.getElementsByClassName('hiddenDeleteButton');

    for(let i = 0; i < buttons.length; i++)
        buttons[i].style.display = 'none';


    document.getElementById('logoutButton').style.display = 'none';
    console.log('HIDE');
}

function deletePost() {
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        console.log(request.responseText);
        if(request.readyState === 4 && request.status === 200)
            if(JSON.parse(request.responseText).status === 'SUCCESS'){
                requestAsync('./getNews.php', retrieveNewsEntries);
            }
    }

    request.open('POST', './deleteNewsItem.php');
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send("id=" + this.value);
}

// updateAdminSession();
// checkAdminToken();