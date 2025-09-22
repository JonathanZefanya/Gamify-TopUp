"use strict";
// Preloader area
const preloader = document.getElementById("preloader");
const preloaderFunction = () => {
    preloader.style.display = "none";
};

// Tooltip
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// cmn select2 start
// $(document).ready(function () {
//     $('.cmn-select2').select2();
// });
// cmn select2 end

// cmn-select2-modal
$(".modal-select").select2({
});

// cmn-select2 with image start
$(document).ready(function () {
    $('.cmn-select2-image').select2({
        templateResult: formatState,
        templateSelection: formatState
    });
});

// select2 function
function formatState(state) {
    if (!state.id) {
        return state.text;
    }
    var baseUrl = "assets/img/mini-flag";
    var $state = $(
        '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.svg" class="img-flag" /> ' + state.text + '</span>'
    );
    return $state;
};
// cmn-select2 with image start


$(document).ready(function () {

    // Jquery UI start
    if ($('#datepicker').length) {
        $("#datepicker").datepicker({
            buttonImageOnly: false,
        });
    }
});

// Dark theme start
const toggleBtn = document.getElementById("toggle-btn");
const body = document.querySelector("body");
toggleBtn.addEventListener("click", function () {
    document.body.classList.toggle("dark-theme");
    if (document.body.classList.contains("dark-theme")) {
        localStorage.setItem("dark-theme", 1);
    } else {
        localStorage.setItem("dark-theme", 0);
    }
    setTheme();
});

function setTheme() {
    const isDarkTheme = localStorage.getItem("dark-theme");
    if (isDarkTheme == 1) {
        document.querySelector('body').classList.add('dark-theme');
        document.getElementById("moon").style.display = "none";
        document.getElementById("sun").style.display = "block";
    } else {
        document.querySelector('body').classList.remove('dark-theme');
        document.getElementById("moon").style.display = "block";
        document.getElementById("sun").style.display = "none";
    }
}
setTheme();
// Dark theme end
