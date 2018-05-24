jQuery(document).ready(function($) {
    //Zorgt ervoor dat je op een tablerow naar een link kan gaan.
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
    // filter voor de zoek balk
    $("#searchbar").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".table .clickable-row").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
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