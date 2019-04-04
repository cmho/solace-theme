
import Chart from "chartjs";

export default {
    init () {
        var contexts = [];
        var charts = [];
        $(window).on('load resize', function() {
            $('canvas').each(function() {
                $(this).attr('width', $(this).parent().width());
                $(this).attr('height', $(this).parent().width()*.75);
            });
        });
        $('#skills-row canvas').each(function(i) {
            var id = $(this).attr('id');
            contexts[i] = document.getElementById(id).getContext('2d');
            charts[i] = new Chart(contexts[i], {
                type: 'bar',
                labels: [0, 1, 2, 3, 4, 5],
                datasets: [
                    {
                        data: $(this).data('points').split(",").map(function(x) { return parseInt(x) }),
                        backgroundColor: ['#fff5a3', '#fff5a3', '#fff5a3', '#fff5a3', '#fff5a3', '#fff5a3']
                    }
                ]
            });
        });
        console.log(contexts);
        console.log(charts);
    }
}