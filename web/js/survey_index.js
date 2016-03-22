$(function () {

    // switchery init
    $('.js-switch').each(function(i,e){ new Switchery(e) });

    // daterangepicker
    $('input[name="SurveySearch[created_at]"],input[name="SurveySearch[updated_at]"]').daterangepicker({
        timePicker: true,
        timePickerSeconds: true,
        timePickerIncrement: 30,
        format: 'YYYY/MM/DD HH:mm:ss',
        ranges: {
            'Today': [moment(moment().dayOfYear(), 'DDD DDDD'), moment(moment().dayOfYear()+1, 'DDD DDDD')],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });

});
