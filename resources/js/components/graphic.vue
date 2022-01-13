<template>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg text-success" v-if="currData !== null && (currData-prevData>0)">Rp. {{parseInt(currGrowth).toLocaleString('en')}}</span>
                    <span class="text-bold text-lg text-danger" v-if="currData !== null && (currData-prevData<0)">Rp. {{parseInt(currGrowth).toLocaleString('en')}}</span>
                    <span>Total of Sales Changes This Month</span>
                  </p>
                  <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success" v-if="currData > prevData && prevData!=0">
                        <i class="fas fa-arrow-up"></i> {{((currData-prevData)/prevData)*100}}%
                    </span>
                    <span class="text" v-else>
                        <i class="fas fa-arrow-up"></i>0%
                    </span>
                    <span class="text-danger" v-if="prevData > currData && prevData!=0">
                      <i class="fas fa-arrow-down"></i> {{((prevData-currData)/prevData)*100}}%
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
      currGrowth:null,
      currData:null,
      prevdata:null,
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
      let colorArr=[];
      
      await axios
          .get('api/getSalesPerMonth/'+this.passing.id)
          .then(({data}) => (this.dataTemp = Object.values(data)));
      
      this.dataTemp=this.dataTemp.sort((a,b) =>{ // sort based on year
                    return a.year - b.year;
                } );

      var date = new Date();
      var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
       
      for(let i=0; i<this.dataTemp.length; i++){
          monthArr[i]=months[this.dataTemp[i].month-1]+" "+this.dataTemp[i].year;
          if(i==0){
            dataArr[i]=this.dataTemp[i].Sum;
            colorArr[i]="#4eba04"
          }else{
            dataArr[i]=this.dataTemp[i].Sum-this.dataTemp[i-1].Sum;
            if(this.dataTemp[i].Sum>this.dataTemp[i-1].Sum){
                colorArr[i]="#4eba04";
            }else{
               colorArr[i]="#ea0100";
            }
            if(this.dataTemp[i].year==date.getFullYear()){
              if(this.dataTemp[i].month==(date.getMonth()+1)){            
                this.currData=this.dataTemp[i].Sum;
                this.prevData=this.dataTemp[i-1].Sum;
                this.currGrowth=dataArr[i];
              }
            }
          }
      }

      this.datacollection = {
            labels: monthArr,
            datasets: [
              {
                type: 'bar',
                // label: 'TurnOver Per Month',
                data: dataArr,
                backgroundColor: colorArr,
              }
            ],   
        }
        this.opsi= {
          scales: {
              yAxes: [{
                ticks:{
                    beginAtZero: true,
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