
import Chart from "chartjs";

export default {
    init () {
        /*$(window).on('load resize', function() {
            $('canvas').each(function() {
                $(this).attr('width', $(this).parent().width());
                $(this).attr('height', $(this).parent().width()*.75);
            });
        });*/
        $("#skills-row canvas").each(function(i, elt) {
          var id = $(this).attr("id");
          var data = $(this)
            .data("points")
            .split(",")
            .map(function(x) {
              return parseInt(x);
            });
          var chart = new Chart(document.getElementById(id), {
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
          console.log(chart);
        });
    }
}