$(function () {

    // switchery init
    $('.js-switch').each(function(i,e){ new Switchery(e) });

    // daterangepicker
    $('input[name="start_at"],input[name="end_at"]').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        timePickerSeconds: true,
        timePickerIncrement: 30,
        format: 'YYYY/MM/DD HH:mm:ss'
    });

    $(document)
        .on('click', '#sections_per_page .switchery', function(e) {
            $('#questions_per_page').toggle('slow');
        })
        .on('click', '#password_protect .switchery', function(e) {
            $('#password_string').toggle('slow');
        });

});
