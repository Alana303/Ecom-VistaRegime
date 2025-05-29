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



document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll('.about, .mission-vision, .why-choose-us, .team, .testimonials, .timeline, .faq, .cta');

    function revealSections() {
        sections.forEach(section => {
            const sectionTop = section.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            if (sectionTop < windowHeight - 50) {
                section.classList.add('show');
            }
        });
    }

    window.addEventListener("scroll", revealSections);
    revealSections();
});

document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll(".about, .mission-vision, .why-choose-us, .team, .testimonials, .timeline, .faq, .cta");

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
            }
        });
    }, { threshold: 0.2 });

    sections.forEach(section => {
        observer.observe(section);
    });
});
