import Chart from 'chart.js';

export default {
    init () {
      var options = {
                scales: {
                  yAxes: [{
                    gridLines: {
                      drawTicks: false,
                      color: "rgba(255,255,255,.5)"
                    },
                    ticks: {
                      beginAtZero: true
                    },
                    labels: {
                      fontColor: "white"
                    }
                  }],
                  xAxes: [{
                    gridLines: {
                      color: "rgba(255,255,255,.5)"
                    }
                  }]
                },
                legend: {
                  display: false
                }
              };
        $(window).on("load", function() {
          $("#skills-row canvas").each(function() {
            var id = $(this).attr("id");
            var data = $(this)
              .data("points")
              .split(",")
              .map(function(x) {
                return parseInt(x);
              });
            new Chart($(this), {
              type: "bar",
              data: {
                labels: [0, 1, 2, 3, 4, 5],
                datasets: [
                  {
                    data: data,
                    fill: false,
                    backgroundColor: "yellow",
                    borderWidth: 1
                  }
                ]
              },
              options: options
            });
          });
          $("#merits-row canvas").each(function () {
            var id = $(this).attr("id");
            var data = $(this)
              .data("points")
              .split(",")
              .map(function (x) {
                return parseInt(x);
              });
            new Chart($(this), {
              type: "bar",
              data: {
                labels: [1, 2, 3, 4, 5],
                datasets: [{
                  data: data,
                  fill: false,
                  backgroundColor: "yellow",
                  borderWidth: 1
                }]
              },
              options: options
            });
          });

          var integrityData = [];
          var labels = $('#integrity').data('labels').split(";").map(function(i) { return i.split(",")});
          var points = $('#integrity').data('points').split(";").map(function(i) { return i.split(",")});
          var characters = $('#integrity').data('characters').split(",");
          var set;
          for (var i = 0; i < characters.length; i++) {
            set = {
              label: characters[i],
              data: points[i]
            }
            array_push(integrityData, set);
          }
          new Chart($('#integrity'), {
            type: 'line',
            datasets: integrityData,
            labels: labels[0],
            options: options
          });
        });
    }
}
