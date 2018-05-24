jQuery(document).ready(function($) {
    //Zorgt ervoor dat je op een tablerow naar een link kan gaan.
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

//Delete berichten

function deleteStudent() {
    return confirm("Weet je zeker dat je deze student wilt verwijderen?")
}

function deleteCompany() {
    return confirm("Weet je zeker dat je dit bedrijf wilt verwijderen?")
}

function deleteExperience() {
    return confirm("Weet je zeker dat je deze geschreve ervaring wilt verwijderen?")
}