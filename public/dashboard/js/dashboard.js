(function($) {
  'use strict';
  $(function() {
    if ($('#sales-statitics-chart').length) {
      var lineChartCanvas = $("#sales-statitics-chart").get(0).getContext("2d");
      var data = {
        labels: ["2006","2007", "2008", "2009", "2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018", "2019"],
        datasets: [
          {
            label: 'Support',
            data: [4500, 6030, 4050, 3300, 4410, 3400, 4200, 3500, 4300, 2400, 4300, 3600, 4400, 3200],
            borderColor: [
              '#2823d0'
            ],
            borderWidth: 3,
            fill: false,
            pointBackgroundColor: "#ffffff",
            pointBorderColor: "#fc7242"
          },
          {
            label: 'Support',
            data: [3700, 5230, 3250, 2500, 3610, 2600, 3400, 2700, 3500, 1600, 3500, 2800, 3600, 2400],
            borderColor: [
              'rgba(86, 70, 255, 0.08)'
            ],
            borderWidth: 4,
            fill: false,
            pointBackgroundColor: "#ffffff",
            pointBorderColor: "#fc7242"
          }
        ]
      };
      var options = {
        scales: {
          yAxes: [{
            gridLines: {
              drawBorder: false,
              display: false
            },
            ticks: {
              display: false,
              stepSize: 2000,
              min: 0
            },
          }],
          xAxes: [{
            display: false,
            gridLines: {
              display: false,
              drawBorder: false,
            },
            ticks: {
              display: false
            }
          }]
        },
        legend: {
          display: false
        },
        elements: {
          line: {
            tension: 0
          },
          point: {
            radius: 0
          }
        },
        stepsize: 1
      };
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: data,
        options: options
      });
    }

    if ($("#goals-chart").length) {
      var areaData = {
        labels: ["Jan", "Feb", "Mar"],
        datasets: [{
            data: [175, 30, 40],
            backgroundColor: [
              "#5646ff","rgba(178, 164, 246, 0.35)","rgba(144, 151, 196, 0.832)"
            ],
            borderWidth: 4,
            borderColor: "#fff"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
          arc: {
              borderWidth: 4,
              borderColor: "#000"
          }
        },      
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        legendCallback: function(chart) { 
          var text = [];
          text.push('<div class="goals-chart">');
            text.push('<div class="item"><div class="legend-label" style="border: 4px solid ' + chart.data.datasets[0].backgroundColor[0] + '"></div>');
            text.push('<p>Delivery</p>');
            text.push('</div>');
            text.push('<div class="item"><div class="legend-label" style="border: 4px solid ' + chart.data.datasets[0].backgroundColor[1] + '"></div>');
            text.push('<p>Support</p>');
            text.push('</div>');
            text.push('<div class="item"><div class="legend-label" style="border: 4px solid ' + chart.data.datasets[0].backgroundColor[2] + '"></div>');
            text.push('<p>Returns</p>');
            text.push('</div>');
          text.push('</div>');
          return text.join("");
        },
      }
      var goalsChartPlugins = {
        beforeDraw: function(chart) {
          var width = chart.chart.width,
              height = chart.chart.height,
              ctx = chart.chart.ctx;
      
          ctx.restore();
          var fontSize = 1.8;
          ctx.font = fontSize + "em sans-serif";
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#6c7293";
      
          var text = "+20%",
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
      
          ctx.fillText(text, textX, textY);
          ctx.save();
        }
      }
      var goalsChartCanvas = $("#goals-chart").get(0).getContext("2d");
      var goalsChart = new Chart(goalsChartCanvas, {
        type: 'doughnut',
        data: areaData,
        options: areaOptions,
        plugins: goalsChartPlugins
      });
      document.getElementById('goals-legend').innerHTML = goalsChart.generateLegend();
    }

    if ($("#revenue-chart").length) {
      var areaData = {
        labels: ["May","Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
        datasets: [
          {
            data: [130, 120, 175, 155, 180, 115, 180, 220],
            backgroundColor: [
              '#5646ff'
            ],
            borderColor: [
              'rgba(0,0,0,0)'
            ],
            borderWidth: 1,
            fill: 'origin',
            label: "services"
          },
          {
            data: [190, 150, 200, 181, 221, 175, 240, 150],
            backgroundColor: [
              'rgba(144, 151, 196, 0.7)'
            ],
            borderColor: [
              'rgba(0,0,0,0)'
            ],
            borderWidth: 1,
            fill: 'origin',
            label: "services"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          filler: {
            propagate: false
          }
        },
        scales: {
          xAxes: [{
            display: true,
            ticks: {
              display: true,
              padding: 10
            },
            gridLines: {
              display: false,
              drawBorder: false,
              color: 'transparent',
              zeroLineColor: '#eeeeee'
            }
          }],
          yAxes: [{
            display: true,
            ticks: {
              display: true,
              autoSkip: false,
              maxRotation: 0,
              stepSize: 50,
              min: 50,
              max: 250,
              padding: 18
            },
            gridLines: {
              drawBorder: false
            }
          }]
        },
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        elements: {
          line: {
            tension: .15
          },
          point: {
            radius: 0
          }
        }
      }
      var revenueChartCanvas = $("#revenue-chart").get(0).getContext("2d");
      var revenueChart = new Chart(revenueChartCanvas, {
        type: 'line',
        data: areaData,
        options: areaOptions
      });
    }
    if ($("#user-statitics-chart").length) {
      var CurrentChartCanvas = $("#user-statitics-chart").get(0).getContext("2d");
      var CurrentChart = new Chart(CurrentChartCanvas, {
        type: 'bar',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May","Jun", "July"],
          datasets: [{
              label: 'Profit',
              data: [16500, 23000, 25000, 19000, 21500, 18000, 22000],
              backgroundColor: '#5646ff'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 2,
              bottom: 0
            }
          },
          scales: {
            yAxes: [{
              display: false,
              gridLines: {
                drawBorder: false
              },
              ticks: {
                display: false,
                fontColor: "#9fa0a2",
                padding: 15,
                stepSize: 5000,
                min: 5000,
                max: 25000
              }
            }],
            xAxes: [{
              stacked: true,
              categoryPercentage: 1,
              ticks: {
                beginAtZero: true,
                display: true,
                padding: 15
              },
              gridLines: {
                color: "rgba(0, 0, 0, 0)",
                display: true
              },
              barPercentage: 0.3
            }]
          },
          legend: {
            display: false
          },
          elements: {
            point: {
              radius: 0
            }
          }
        }
      });
    }
  });
})(jQuery);