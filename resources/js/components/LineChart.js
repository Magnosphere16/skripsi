import { Bar, Line, mixins } from 'vue-chartjs'
const { reactiveProp } = mixins

export default {
  extends: Bar,Line,
  mixins: [reactiveProp],
  props: ['chartData','options'],
  mounted () {
    this.renderChart(this.chartData, this.options)
  },
}

console.log("chart 1 nya dah ke import");