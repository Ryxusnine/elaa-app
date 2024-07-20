/**
 * Dashboard Analytics
 */

'use strict';

(function () {
  let cardColor, headingColor, axisColor, shadeColor, borderColor;

  cardColor = config.colors.white;
  headingColor = config.colors.headingColor;
  axisColor = config.colors.axisColor;
  borderColor = config.colors.borderColor;

  // Total Revenue Report Chart - Bar Chart
  // --------------------------------------------------------------------
  const totalSentimen = document.querySelector('#totalSentimen'),
    totalSentimenChartOptions = {
      chart: {
        type: 'bar'
      },
      plotOptions: {
        bar: {
          horizontal: true,
        }
      },
      series: [{
        data: [{
          x: 'Negatif',
          y: document.querySelector('#totalSentimen').getAttribute('data-negative'),
          fillColor: '#ff3e1d'
        }, {
          x: 'Netral',
          y: document.querySelector('#totalSentimen').getAttribute('data-netral'),
          fillColor: '#233446'
        }, {
          x: 'Positif',
          y: document.querySelector('#totalSentimen').getAttribute('data-positive'),
          fillColor: '#71dd37'
        }]
      }]
    };

  const totalAnalisis = document.querySelector('#totalAnalisis'),
    totalRevenueChartOptionsAnalisis = {
      chart: {
        type: 'bar'
      },
      plotOptions: {
        bar: {
          horizontal: true
        }
      },
      series: [{
        data: [{
          x: 'Negatif',
          y: document.querySelector('#totalAnalisis').getAttribute('data-negative'),
          fillColor: '#ff3e1d'
        }, {
          x: 'Netral',
          y: document.querySelector('#totalAnalisis').getAttribute('data-netral'),
          fillColor: '#233446'
        }, {
          x: 'Positif',
          y: document.querySelector('#totalAnalisis').getAttribute('data-positive'),
          fillColor: '#71dd37'
        }]
      }]
    };

  if (typeof totalSentimen !== undefined && totalSentimen !== null) {
    const totalSentimenChart = new ApexCharts(totalSentimen, totalSentimenChartOptions);
    totalSentimenChart.render();
  }

  if (typeof totalAnalisis !== undefined && totalAnalisis !== null) {
    const totalAnalisisChart = new ApexCharts(totalAnalisis, totalRevenueChartOptionsAnalisis);
    totalAnalisisChart.render();
  }
})();
