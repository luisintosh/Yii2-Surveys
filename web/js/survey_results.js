
$(function () {
    // init tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    $('.pie-chart').each(function(i,e) {
        // For a pie chart
        new Chart(this.getContext("2d")).Pie(JSON.parse(this.dataset.json),{});
        //console.log( JSON.parse(this.dataset.json) );
    })
});
