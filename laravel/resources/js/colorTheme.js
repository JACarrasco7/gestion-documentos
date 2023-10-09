import $ from "jquery";

colorTheme();

function colorTheme() {
    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (
        localStorage.getItem("color-theme") === "dark" ||
        (!("color-theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }

    var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
    var themeToggleLightIcon = document.getElementById(
        "theme-toggle-light-icon"
    );

    // Change the icons inside the button based on previous settings
    if (
        localStorage.getItem("color-theme") === "dark" ||
        (!("color-theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        themeToggleLightIcon.classList.remove("hidden");
        $("#company-logo").attr(
            "src",
            "./laravel/public/img/brand/vertical_logo.png"
        );
    } else {
        themeToggleDarkIcon.classList.remove("hidden");
        $("#company-logo").attr(
            "src",
            "./laravel/public/img/brand/vertical_logo.png"
        );
    }

    var themeToggleBtn = document.getElementById("theme-toggle");

    themeToggleBtn.addEventListener("click", function () {
        // toggle icons inside button
        themeToggleDarkIcon.classList.toggle("hidden");
        themeToggleLightIcon.classList.toggle("hidden");

        // if set via local storage previously
        if (localStorage.getItem("color-theme")) {
            if (localStorage.getItem("color-theme") === "light") {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
                $("#company-logo").attr(
                    "src",
                    "./laravel/public/img/brand/vertical_logo.png"
                );
            } else {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
                $("#company-logo").attr(
                    "src",
                    "./laravel/public/img/brand/vertical_logo.png"
                );
            }

            // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains("dark")) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
                $("#company-logo").attr(
                    "src",
                    "./laravel/public/img/brand/vertical_logo.png"
                );
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
                $("#company-logo").attr(
                    "src",
                    "./laravel/public/img/brand/vertical_logo.png"
                );
            }
        }
    });
}
