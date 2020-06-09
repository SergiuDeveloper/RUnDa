let newsContainer = document.getElementById("newsContainer");

function generateNewsItem(title, content){
    let itemContainer = document.createElement("div");
        itemContainer.className = "newsItem";

    let titleText = document.createElement("h3");
        titleText.innerText = title;

    let contentText = document.createElement("p");
        contentText.innerText = content;

    itemContainer.appendChild(titleText);
    itemContainer.appendChild(contentText);

    // newsContaineradd(itemContainer);

    // let outerDiv =
    //     '<div class="newsItem">' +
    //     '<h3>' +
    //     title +
    //     '</h3>' +
    //     '<p>' +
    //     content +
    //     '</p>' +
    //     '</div>';

    newsContainer.appendChild(itemContainer);
}

function escapeHTML(unsafeText) {
    let div = document.createElement('div');
    div.innerText = unsafeText;
    return div.innerHTML;
}

generateNewsItem('Sample Title 1', 'Content medium medium medium');
generateNewsItem('Sample Title 2', 'Content smol');
generateNewsItem('Sample Title 3', 'Content bigggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg');