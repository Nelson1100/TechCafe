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
const input = document.getElementById("search");
const searchBox = document.getElementById("search-bar");
const Icon = document.getElementsByClassName("submit")[0];

// Function to trigger search
function triggerSearch() {
    const query = input.value.trim();
    if (query !== "") {
        window.location.href = "shop.php?ProductName=" + encodeURIComponent('%' + query + '%');
    } else {
        searchBox.classList.toggle("active");
    }
}

// When search icon is clicked
Icon.onclick = function () {
    triggerSearch();
};

// When Enter key is pressed
input.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent form submission if wrapped in a <form>
        triggerSearch();
    }
});