import Chart from 'chart.js';

export default {
    init () {
      function randomColor() {
        var one = Math.floor(Math.random()*255);
        var two = Math.floor(Math.random() * 255);
        var three = Math.floor(Math.random() * 255);
        return "rgba("+one+", "+two+", "+three+", 1)";
      }
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
          var points = $('#integrity').data('points').split(";").map(function(i) { return i.split(",").map(parseInt)});
          var characters = $('#integrity').data('characters').split(",");
          var set;
          var color;
          for (var i = 0; i < characters.length; i++) {
            color = randomColor();
            set = {
              label: characters[i],
              data: points[i],
              backgroundColor: color,
              borderColor: color
            };
            integrityData.push(set);
          }
          console.log(labels);
          new Chart($('#integrity'), {
            type: 'line',
            datasets: integrityData,
            labels: labels[0],
            options: options
          });
        });
    }
}
