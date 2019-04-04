
import Chart from 'chartjs';

export default {
    init () {
        $(window).on('load', function() {
            $("#skills-row canvas").each(function(i, elt) {
              var data = $(this)
                .data("points")
                .split(",")
                .map(function(x) {
                  return parseInt(x);
                });
              var chart = new Chart($(this), {
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
                options: {
                  scales: {
                    yAxes: [
                      {
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
                      }
                    ],
                    xAxes: [
                      {
                        gridLines: {
                          color: "rgba(255,255,255,.5)"
                        }
                      }
                    ]
                  },
                  legend: {
                    display: false
                  }
                }
              });
            });
        });
    }
}