
$(function () {
    // init tooltips
    $('[data-toggle="tooltip"]').tooltip();
    // init wysihtml5 editors
    $('.wysihtml5-editor textarea').wysihtml5();


    var focusedElement;
    $(document)
        // auto select textbox text
        .on('focus', 'input[type="text"]', function (e) {
            if (focusedElement == $(this)) return; // the user can edit the content without select all
            focusedElement = $(this);
            setTimeout(function () { focusedElement.select(); }, 50);
        });

});
