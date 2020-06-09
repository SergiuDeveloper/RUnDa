let newsContainer = document.getElementById("newsContainer");

function generateNewsItem(ID, title, content){
    let itemContainer = document.createElement("div");
    itemContainer.className = "newsItem";
    itemContainer.id = ID;

    let titleText = document.createElement("h3");
    titleText.innerText = escapeHTML(title);

    let contentText = document.createElement("p");
    contentText.innerText = escapeHTML(content);

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
    Object.values(responseJSON).forEach(function (value) {
        generateNewsItem(value.ID, value.title, value.content);
    })
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