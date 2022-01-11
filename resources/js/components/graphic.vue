<template>
    <line-chart :chart-data="datacollection" :height="250"></line-chart>
</template>

<script>

import LineChart from './LineChart.js'

export default {
  components: {
    LineChart
  },
  data(){
    return {
      datacollection: null
    }
  },
  mounted () {
    this.fillData()
  },
  methods: {

    fillData ()
    {
      this.datacollection = {
        labels: ['January','February','March','April','May', 'June' , 'July'],
        datasets: [
          {
            backgroundColor: '#4666d0',
            data: [ 20, 40, 50, 20, 50, 40]
          },
        ]
      }
    }
  }
}
</script>

<style lang="css">
.small {
  max-width: 800px;
  margin:  50px auto;
}
</style>