<template>
    <line-chart :chart-data="datacollection" :height="250" :options="options"></line-chart>
</template>

<script>

import LineChart from './LineChart.js'

export default {
  components: {
    LineChart
  },
  props: ['passing'],
  data(){
    return {
      datacollection: null,
      dataTemp: {},
    }
  },
  mounted () {
    this.fillData()
  },
  methods: {
    async fillData ()
    {

      let dataArr=[];
      let monthArr=[];
      await axios
          .get('api/getSalesPerMonth/'+this.passing.id)
          .then(({data}) => (this.dataTemp = Object.values(data)));
      
      var date = new Date();
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      for(let i=0; i<this.dataTemp.length; i++){
        if(this.dataTemp[i].year==date.getFullYear()){
          monthArr[i]=months[this.dataTemp[i].month-1];
          dataArr[i]=this.dataTemp[i].Sum;
        }
      }
      this.datacollection = {
            labels: monthArr,
            datasets: [
              {
                type: 'bar',
                label: 'TurnOver Per Month',
                backgroundColor: '#4666d0',
                data: dataArr,
              }
            ]   
        }
        const options = {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        };
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