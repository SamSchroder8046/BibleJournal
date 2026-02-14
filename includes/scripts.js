// console.log("script loaded");

function updateConfig(key, value) {
    config[key] = value.toString();
    return config;
}

function getVersionsByLanguage(language, jsonData) {
    let versions = [];
    for (const version of jsonData) {
        if (version['language']['name'] === language) {
            versions.push(version);
        }
    }
    const newConfig = updateConfig("language", language);
    console.log(newConfig.toString())
    return versions;
}

function getBooksByVersion(version, jsonData) {
    let books = [];
    for (const book of jsonData) {
        if (book['language']['name'] === language) {
            books.push(book);
        }
    }
    return books;
}

function displayList(array, type) {
    const subHeader = document.getElementById('subHeader');
    const displayList = document.getElementById('displayList');
    subHeader.innerHTML = type[0].toUpperCase() + type.slice(1).toLowerCase() + "s";
    displayList.innerHTML = "";
    for (const element of array) {
        // console.log(version['version']);
        displayList.innerHTML += "<li data_content_type=" + type + " attr_" + type + "=" + element[type] + "class=" + type + "-item" + ">" + element[type] + "</li>";
    }
}

document.addEventListener("click", (element) => {
    // console.log(element.target.toString() + " clicked");
    if (element.target.getAttribute("data_content_type") === "language") {
        console.log(element.target.toString() + " clicked of type " + element.target.getAttribute("data_content_type"));
        displayList(getVersionsByLanguage(element.target.getAttribute("attr_language"), bibleData), "version");
    } else if (element.target.getAttribute("data_content_type") === "version") {
        console.log("WIP");
        // displayList();
    }
});