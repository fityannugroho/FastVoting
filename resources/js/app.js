import "./bootstrap";
import "../sass/app.scss";
import "./fontawesome/fontawesome-icons.min";

// Import static assets
import.meta.glob(["../images/**"]);

const navbarToggler = document.querySelector(".navbar-toggler");

// Change navbar toggler icon when clicked.
if (navbarToggler) {
    navbarToggler.addEventListener("click", () => {
        if (navbarToggler.classList.contains("collapsed")) {
            navbarToggler.innerHTML = '<i class="fa-solid fa-bars"></i>';
        } else {
            navbarToggler.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        }
    });
}

// Toggle the theme when clicked.
const themeDropdown = document.querySelector('#themeDropdown');
const btnLight = document.querySelector('#btnLight');
const btnDark = document.querySelector('#btnDark');
const btnAuto = document.querySelector('#btnAuto');

function setTheme(theme) {
    document.documentElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem('theme', theme);
    if (theme === 'dark') {
        themeDropdown.innerHTML = '<i class="fa-solid fa-moon fa-lg"></i>';
    } else if (theme === 'light') {
        themeDropdown.innerHTML = '<i class="fa-solid fa-sun fa-lg"></i>';
    }
}

function setThemeBasedOnMediaQuery() {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const newTheme = prefersDark ? 'dark' : 'light';
    setTheme(newTheme);
}

btnDark.addEventListener('click', () => setTheme('dark'));
btnLight.addEventListener('click', () => setTheme('light'));
btnAuto.addEventListener('click', setThemeBasedOnMediaQuery);

// Set the theme based on media query as default.
setThemeBasedOnMediaQuery();

// Set the theme based on the user's preference.
const theme = localStorage.getItem('theme');
if (theme) {
    setTheme(theme);
}

// Disable the file input button when clicked.
document.addEventListener("trix-file-accept", function (e) {
    e.preventDefault();
});

// disable the heading1 in the trix editor
document.addEventListener("trix-change", function (e) {
    if (e.target.tagName === "H1") {
        e.preventDefault();
    }
});
