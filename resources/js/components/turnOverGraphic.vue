<template>
<div class="container">
      <div class="card-body">
        <div class="d-flex">
                <p class="d-flex flex-column">
                <span class="text-bold text-lg" v-if="currData !== null">Rp. {{parseInt(currData).toLocaleString('en')}}</span>
                <span>This Month Amount of Turn Over</span>
            </p>
            <p class="ml-auto d-flex flex-column text-right">
                <span class="text" v-if="currData-prevData==0 || prevData-currData==0 || currData==null || prevData==null">
                    0%
                </span>
                <span class="text-success" v-else-if="currData > prevData">
                    <i class="fas fa-arrow-up"></i> {{(((currData-prevData)/prevData)*100).toFixed(2)}}%
                </span>
                <span class="text-danger" v-else-if="prevData > currData">
                    <i class="fas fa-arrow-down"></i> {{(((prevData-currData)/prevData)*100).toFixed(2)}}%
                </span>
                <span class="text-muted">Since last Month</span>
            </p>
        </div>
        <div class="row justify-content-center">
            <line-chart v-if="datacollection !== null" :chart-data="datacollection" :height="250" :options="opsi"></line-chart>
        </div>
    </div>
</div>
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
      opsi: {},
      turn_over: {},
      currData:null,
      prevData:null,
    }
  },
  mounted () {
    this.fillData()
  },
  methods: {
    async fillData ()
    {

      await axios
          .get('api/userTurnOver/'+this.passing.id)
          .then(({data}) => (this.turn_over = data));

      let dataArr=[];
      let targetArr=[];
      let monthArr=[];
      await axios
          .get('api/getTurnOverPerMonth/'+this.passing.id)
          .then(({data}) => (this.dataTemp = Object.values(data)));

      this.dataTemp=this.dataTemp.sort((a,b) =>{ // sort based on year
                    return a.year - b.year;
                } );
      console.log(this.passing.id);
      console.log(this.dataTemp);
      var date = new Date();
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      
        if(this.dataTemp.length==1){
        dataArr[0]=this.dataTemp[0].tod_turn_over_amount;
        targetArr[0]=this.dataTemp[0].tod_target_turn_over;

        this.currData=this.dataTemp[0].tod_turn_over_amount;
        monthArr[0]=months[this.dataTemp[0].tod_month-1]+" "+this.dataTemp[0].tod_year;
        }else{
          for(let i=0; i<this.dataTemp.length; i++){
              monthArr[i]=months[this.dataTemp[i].tod_month-1]+" "+this.dataTemp[i].tod_year;
              dataArr[i]=this.dataTemp[i].tod_turn_over_amount;
              if(this.dataTemp[i].tod_target_turn_over<=0){
                targetArr[i]=this.turn_over.to_final_target_turnover/this.turn_over.to_turnover_duration;
              }else{
                targetArr[i]=this.dataTemp[i].tod_target_turn_over;
              }
              
              if(this.dataTemp[i].year==date.getFullYear()){
                  if(this.dataTemp[i].month==(date.getMonth()+1)){            
                    this.currData=this.dataTemp[i].tod_turn_over_amount;
                    this.prevData=this.dataTemp[i-1].tod_turn_over_amount;
                  }
              }
          }
        }
      this.datacollection = {
            labels: monthArr,
            datasets: [
              {
                type: 'bar',
                backgroundColor: '#4666d0',
                data: dataArr,
              },
              {
                type: 'line',
                backgroundColor:'rgba(255, 99, 132, 0.2)',
                data: targetArr,
              }
            ]   
        }
        this.opsi= {
          scales: {
              yAxes: [{
                ticks:{
                    beginAtZero: true,
                    min:0
                }
              }]
          },
          legend: {
            display: false
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