const openSearch = document.getElementById("buttonSearch");
const closeSearch = document.getElementById("closeSearch");

console.log('ok');
console.log(openSearch.style.display);
console.log(closeSearch.style.display);

if((openSearch.style.display == "block") && (closeSearch.style.display == "none")){
    console.log('to open');
        openSearch.addEventListener("click", () => {
            document.getElementById("formSearch").style.display = "block";
            document.getElementById("initSearch").style.display = "block";
            closeSearch.style.display = "block";
            openSearch.style.display = "none";
        });
}

if((closeSearch.style.display == "block") && (openSearch.style.display == "none")){
    console.log('to close');
        closeSearch.addEventListener("click", () => {
            document.getElementById("formSearch").style.display = "none";
            document.getElementById("initSearch").style.display = "none";
            closeSearch.style.display = "none";
            openSearch.style.display = "block";
        });
}

