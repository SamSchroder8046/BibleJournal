// console.log("script loaded");

// function updateVersions() {
//
// }
//
// function updateConfig(key, value) {
//     config[key] = value.toString();
//     return config;
// }
//
// function getVersionsByLanguage(language, jsonData) {
//     let versions = [];
//     for (const version of jsonData) {
//         if (version['language']['name'] === language) {
//             versions.push(version);
//         }
//     }
//     const newConfig = updateConfig("language", language);
//     console.log(newConfig.toString())
//     return versions;
// }

// function getBooksByVersion(version, jsonData) {
//     let books = [];
//     for (const book of jsonData) {
//         if (book['language']['name'] === language) {
//             books.push(book);
//         }
//     }
//     return books;
// }
//
// function displayList(array, type) {
//     const subHeader = document.getElementById('subHeader');
//     const displayList = document.getElementById('displayList');
//     subHeader.innerHTML = type[0].toUpperCase() + type.slice(1).toLowerCase() + "s";
//     displayList.innerHTML = "";
//     for (const element of array) {
//         // console.log(version['version']);
//         displayList.innerHTML += "<li data_content_type=" + type + " attr_" + type + "=" + element[type] + "class=" + type + "-item" + ">" + element[type] + "</li>";
//     }
// }

// hide irrelevant Bible versions when language selected

function resetVersionRadioButtons (language = "") {
    const versionRadioContainer = document.getElementById("version-radio-container");
    versionRadioContainer.innerHTML = "";
    bibleData.sort((a, b) => {
        let x = a["version"].toLowerCase();
        let y = b["version"].toLowerCase();
        if (x < y) {return -1};
        if (x > y) {return 1};
        return 0;
    });

    for (const version of bibleData) {
        if (language === "" || version["language"]["name"] === language) {
            // create version container
            const versionContainer = document.createElement("div");
            versionContainer.className = "version-container";
            versionContainer.id = version["version"] + "-container";
            const versionName = version["version"];

            // create input element
            const inputEl = document.createElement("input");
            inputEl.className = "version-radio-button";
            inputEl.type = "radio";
            inputEl.id = versionName;
            inputEl.name = "bible-version";
            inputEl.value = versionName;
            inputEl.required = true;

            // create label element
            const labelEl = document.createElement("label");
            labelEl.className = "version-label";
            labelEl.for = versionName;
            labelEl.innerHTML = versionName;

            // create breakline element
            const breakEl = document.createElement("br");

            // structure elements and add to version container
            versionRadioContainer.appendChild(versionContainer);
            versionContainer.appendChild(inputEl);
            versionContainer.appendChild(labelEl);
            versionContainer.appendChild(breakEl);
        }
    }
}

languageRadioButtons = document.getElementsByClassName("language-radio-button")
versionLabels = document.getElementsByClassName("version-label");
console.log(languageRadioButtons);
for (const radioButton of languageRadioButtons) {
    radioButton.addEventListener("click", (element) => {
        // console.log(element.target.toString() + " clicked");
        // if (element.target.getAttribute("data_content_type") === "language") {
        //     console.log(element.target.toString() + " clicked of type " + element.target.getAttribute("data_content_type"));
        //     displayList(getVersionsByLanguage(element.target.getAttribute("attr_language"), bibleData), "version");
        // } else if (element.target.getAttribute("data_content_type") === "version") {
        //     console.log("WIP");
        //     // displayList();
        // }
        resetVersionRadioButtons(element.target.getAttribute("value"));
        // const versionRadioButtons = document.getElementsByClassName("version-radio-button");
        // let acceptedVersions = []
        // for (const version of bibleData) {
        //     console.log(version.toString())
        //     console.log("language: " + version['language']['name']);
        //     console.log("clicked language: " + element.target.getAttribute("value"));
        //     if (version['language']['name'] === element.target.getAttribute("value")) {
        //         console.log("\n=====\nFound a match!\n=====\n");
        //         acceptedVersions.push(version['version']);
        //     }
        // }
        // for (const acceptedVersion of acceptedVersions) {
        //     console.log(acceptedVersion.toString());
        // }
        // console.log(element.target.getAttribute("value"));
        // for (const radioButton of versionRadioButtons) {
        //     for (const acceptedversion of acceptedVersions) {
        //         if (!(radioButton.getAttribute("value").includes(acceptedversion))) {
        //             console.log("removing " + radioButton.getAttribute("value"));
        //             document.getElementById(radioButton.getAttribute("value") + "-container").innerHTML = "";
        //         }
        //     }
        // }
    });
}