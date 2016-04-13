$(function () {
    // init tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // http://bootstrap-datepicker.readthedocs.org/en/latest/
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd'
    });

    // https://eonasdan.github.io/bootstrap-datetimepicker/
    $('.timepicker').datetimepicker({
        format: 'HH:mm:ss'
    });

    $('.radio-btn:checked').each(function (i,e) {
        var id = e.dataset.id;
        $(e).closest('.answer-container').find('.id-question-option').attr({'disabled':false, 'value': id});
    });
    $('.radio-btn').on('change', function (e) {
        var id = this.dataset.id;
        $(this).closest('.answer-container').find('.id-question-option').attr({'disabled':false, 'value': id});
    });
    // copy text to radio button value
    $('.other-option-text').on('input propertychange paste', function (e) {
        var id = this.dataset.id;
        $(this).closest('.answer-container').find('input[data-other]').attr({'value': this.value});
    });
    // move "other" option to end
    $('.radio-options').each(function (i,e) {
        var inputLen = $(this).find('label input').length,
            inputOther = null;
        $(this).find('label').addClass('col-md-3');

        $(this).find('label input').each(function (i2, e2) {
            if ('other' in e2.dataset) {
                inputOther = $(e2).parent();
            }

            if (i2 == inputLen-1 && inputOther != null) {
                $(inputOther).closest('.radio-options').append($(inputOther));
            }
        });
    });


    // set data from client
    $('#interview-web_browser').val($.browser.name);

    $.getJSON('http://ip-api.com/json', function (data) {
        $('#interview-country').val(data.countryCode);
        $('#interview-ip_address').val(data.query);
    });

    $('#loading').hide();

});

// show by sections
function showBySections() {
    var currentSection = 0,
        sections = $('.survey-section'),
        prevBtn = $('#previous-btn'),
        nextBtn = $('#next-btn'),
        submitBtn = $('#submit-btn');

    // hide elements
    sections.hide();
    prevBtn.hide();
    //nextBtn.hide();
    submitBtn.hide();

    // show currentSection
    $(sections[0]).slideDown();

    $(document)
        .on('click', '#previous-btn', function (e) {

            $(sections[currentSection]).slideUp();
            --currentSection;
            $(sections[currentSection]).slideDown();

            prevBtn.show();
            nextBtn.show();

            if (currentSection == 0) {
                prevBtn.hide();
            }

        })
        .on('click', '#next-btn', function (e) {

            $(sections[currentSection]).slideUp();
            ++currentSection;
            $(sections[currentSection]).slideDown();

            prevBtn.show();
            nextBtn.show();

            if (currentSection === (sections.length-1)) {
                nextBtn.hide();
                submitBtn.show();
            }
        });
}

// show by questions
function showByQuestions() {
    var currentSection = 0,
        currentQuestion = 0,
        sections = $('.survey-section'),
        questions = $('.survey-question'),
        prevBtn = $('#previous-btn'),
        nextBtn = $('#next-btn'),
        submitBtn = $('#submit-btn');

    // hide elements
    sections.hide();
    questions.hide();
    prevBtn.hide();
    //nextBtn.hide();
    submitBtn.hide();

    // show currentSection
    $(sections[0]).slideDown();
    $(questions[0]).slideDown();

    $(document)
        .on('click', '#previous-btn', function (e) {
            var firstQuestionFromSection = $(sections[currentSection]).find('.survey-question')[0];
            if (questions[currentQuestion] === firstQuestionFromSection) {
                $(sections[currentSection]).slideUp();
                --currentSection;
                $(sections[currentSection]).slideDown();
            }

            $(questions[currentQuestion]).slideUp();
            --currentQuestion;
            $(questions[currentQuestion]).slideDown();

            prevBtn.show();
            nextBtn.show();

            if (currentQuestion == 0 && currentSection == 0) {
                prevBtn.hide();
            }

        })
        .on('click', '#next-btn', function (e) {
            var currQuesList = $(sections[currentSection]).find('.survey-question');
            var lastQuestionFromSection = currQuesList[currQuesList.length-1];
            if (questions[currentQuestion] === lastQuestionFromSection) {
                $(sections[currentSection]).slideUp();
                ++currentSection;
                $(sections[currentSection]).slideDown();
            }

            $(questions[currentQuestion]).slideUp();
            ++currentQuestion;
            $(questions[currentQuestion]).slideDown();

            prevBtn.show();
            nextBtn.show();

            if (currentSection === (sections.length-1) && currentQuestion == (questions.length-1)) {
                nextBtn.hide();
                submitBtn.show();
            }
        });
}