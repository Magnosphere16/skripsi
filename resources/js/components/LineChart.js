import { Bar, Line, mixins } from 'vue-chartjs'
const { reactiveProp } = mixins

export default {
  extends: Bar,Line,
  mixins: [reactiveProp],
  props: ['options'],
  mounted () {
    this.options={
      scales: {
        yAxes: [{
          stacked: true,
          ticks: {
            beginAtZero: true,
            min: 0,
          },
        }],
        xAxes: [{
          stacked: true,
          ticks: {
            beginAtZero: true,
            categoryPercentage: 0.5,
            barPercentage: 1,
          },
        }],
      },
      responsive: true,
      maintainAspectRatio: false,
    }
    this.renderChart(this.chartData, this.options)
  },
}

console.log("chart 1 nya dah ke import");