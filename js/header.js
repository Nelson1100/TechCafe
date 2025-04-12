/* Header hide and show */
const header = document.getElementById('header');
const headerHeight = header.offsetHeight;
let prevScrollPos = window.pageYOffset;

function handleScroll() {
    const currentScrollPos = window.pageYOffset;
    const scrolledDown = prevScrollPos <= currentScrollPos;

    if (scrolledDown && currentScrollPos >= headerHeight / 3) {
        header.style.top = `-${headerHeight}px`;
    } else {
        header.style.top = '0';
    }

    prevScrollPos = currentScrollPos;
}

function debounce(func, wait) {
    let timeout;
    return function () {
        const context = this,
            args = arguments;
        const later = function () {
            timeout = null;
            func.apply(context, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

window.onscroll = debounce(handleScroll, 0);

// Search Bar
var searchBox=document.getElementById("search-bar");
        var Icon=document.getElementsByClassName("submit")[0];
        Icon.onclick=function(){
            searchBox.classList.toggle("active");
        }