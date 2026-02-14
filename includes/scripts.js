// console.log("script loaded");

// hide irrelevant Bible versions when language selected
function filterVersionRadioButtons (language = "") {
    const versionRadioContainer = document.getElementById("version-radio-container");
    versionRadioContainer.innerHTML = "";
    bibleData.sort((a, b) => {
        let x = a["version"].toLowerCase();
        let y = b["version"].toLowerCase();
        if (x < y) {return -1;}
        if (x > y) {return 1;}
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
            inputEl.value = version["id"];
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

const languageSelector = document.getElementById("language");
filterVersionRadioButtons(languageSelector ? languageSelector.value : "");
languageSelector.addEventListener("input", (event) => {
    console.log("Language changed");
    filterVersionRadioButtons(event.target.value);
});