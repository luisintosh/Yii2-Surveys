$(function() {

    $(document).on('click', '.add-textbox-option', function (e) {
            e.preventDefault();

            var checkbox = $(this).find('input[type=checkbox]');
            checkbox.prop('checked', !checkbox.prop('checked'));

            var opabierta = $(this).parent().parent().find('.textbox-option').toggle();
        });

    // pjax functions
    if ($.support.pjax) {
        $(document)
            .on('pjax:send', function(e) {
                $('#loading').toggle();
            })
            .on('pjax:complete', function(e) {
                $('#loading').toggle();
                if (window.pjax_pos) window.scroll(0, window.pjax_pos);
            })
            .on('click', '.survey-action', function(e) {
                e.preventDefault();

                window.pjax_pos = e.pageY;
                var dataset = this.dataset;

                if (dataset['action']) {
                    var survey = $('#datasurvey');
                    var surveyData = survey.serializeArray();
                    var urlsurvey = survey.attr('action');

                    surveyData.push({name: 'action[type]', value: dataset['action']});
                    surveyData.push({name: 'action[survey]', value: dataset['survey']});
                    surveyData.push({name: 'action[section]', value: dataset['section']});
                    surveyData.push({name: 'action[question]', value: dataset['question']});
                    surveyData.push({name: 'action[option]', value: dataset['option']});

                    // request
                    $.pjax({url: urlsurvey, container: '#pjax-container', type:'POST', data:surveyData, push: false });
                }
            });
    }

});
