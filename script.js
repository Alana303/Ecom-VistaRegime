// script.js
// Toggle Menu for Mobile View
document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.getElementById("menuIcon");
    const navLinks = document.getElementById("navLinks");

    // Toggle menu on click
    menuIcon.addEventListener("click", function () {
        navLinks.classList.toggle("active");
    });

    // Show menu on hover (for small screens)
    menuIcon.addEventListener("mouseenter", function () {
        navLinks.classList.add("active");
    });

    navLinks.addEventListener("mouseleave", function () {
        navLinks.classList.remove("active");
    });
});


function toggleMenu() {
    document.querySelector(".nav-links").classList.toggle("active");
}

// Show "Back to Top" button on scroll
window.onscroll = function() {
    let backToTopButton = document.getElementById("backToTop");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        backToTopButton.style.display = "block";
    } else {
        backToTopButton.style.display = "none";
    }
};

// Scroll to top when "Back to Top" button is clicked
document.getElementById("backToTop").addEventListener("click", function() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});