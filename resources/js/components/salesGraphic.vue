<template>
    <div class="card-body">
    <div class="d-flex">
        <p class="d-flex flex-column">
        <span class="text-bold text-lg" v-if="currData !== null">{{currData}} Transactions</span>
        <span class="text-bold text-lg" v-if="currData == null">0 Transactions</span>
        <span>Total Sales Transaction This Month</span>
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
        <line-chart v-if="datacollection !== null" :chart-data="datacollection" :height="250" :options="opsi"></line-chart>
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
      currData:null,
      prevData:null
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
          .get('api/getSalesTransactionPerMonth/'+this.passing.id)
          .then(({data}) => (this.dataTemp = Object.values(data)));

      this.dataTemp=this.dataTemp.sort((a,b) =>{ // sort based on year
                    return a.year - b.year;
                } );
      var date = new Date();
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
        if(this.dataTemp.length==1){
        dataArr[0]=this.dataTemp[0].count;

        this.currData=this.dataTemp[0].count;
        monthArr[0]=months[this.dataTemp[0].month-1]+" "+this.dataTemp[0].year;
        }else{
          for(let i=0; i<this.dataTemp.length; i++){
              monthArr[i]=months[this.dataTemp[i].month-1]+" "+this.dataTemp[i].year;
              dataArr[i]=this.dataTemp[i].count;
              if(i==0){
                dataArr[i]=this.dataTemp[i].count;
                this.currData=this.dataTemp[i].count;
              }else{
                if(this.dataTemp[i].year==date.getFullYear()){
                    if(this.dataTemp[i].month==(date.getMonth()+1)){            
                      this.currData=this.dataTemp[i].count;
                      this.prevData=this.dataTemp[i-1].count;
                    }
                }
              }
          }
        }

      this.datacollection = {
            labels: monthArr,
            datasets: [
              {
                type: 'bar',
                label: 'Sales Transactions Per Month',
                backgroundColor: '#4666d0',
                data: dataArr,
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