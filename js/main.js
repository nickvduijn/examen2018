jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});

function deleteStudent() {
    return confirm("Weet je zeker dat je deze student wilt verwijderen?")
}

function deleteCompany() {
    return confirm("Weet je zeker dat je dit bedrijf wilt verwijderen?")
}