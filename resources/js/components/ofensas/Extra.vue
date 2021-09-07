<template>
<v-row  dense>
       <v-col v-for="chart in charts" v-bind:key="chart.id" cols="6" dense>
          <v-card>
       <v-card-text>
            <highcharts :options="chart" ></highcharts>
       </v-card-text>
    </v-card>
       </v-col>
    </v-row>
</template>
<script>

export default {
    data() {
     return {
        //loading:false,
        searches:[],

      charts :[]

     }
  },
  mounted() {
      this.getData()

  },
    created() {

    // this.creaChart();


  },
methods:{
    async getData(){
        await this.topOffenseCategories();
        //await this.mostRecentOffenses();
        //wait this.creaChart();
     },
    topOffenseCategories() {
        //this.loading=true;
         //this.axios.defaults.headers.common['Range'] = 'items=0-9';

        this.axios
            .get(`/api/searches`)
            .then(response => {
                   this.searches = response.data;
                    //console.log(response.data);
                        var aux={};
                        var temp=[];
                    for (let index = 0; index < this.searches.length; index++) {
                        const element = this.searches[index];
                         //element.loading=true;
                        this.axios
                                .get(`/api/busqueda/${element.search_id}`)
                                .then(resp => {
                                    //element.loading=false;
                                    console.log(resp.data.events);
                                        aux.id=index;
                                        aux = {
                                            yAxis:{
                                                },
                                                xAxis:{},
                                            chart: {type:'column'},
                                            title: {text: element.description},
                                            series:[]
                                    }
                                    resp.data.events.forEach(e => {

                                        aux.yAxis={
                                            title:{
                                                text:element.data
                                            }
                                        }
                                        aux.xAxis={
                                            categories:[element.name]
                                        }
                                        aux.series.push({name:(e[element.name]) ? e[element.name] : 'N/A',data:[e[element.data]]})

                                    });
                                temp.push(aux)
                                }).catch(err => console.log(err))
                                .finally(() => {
                                    });
                    }
                 this.charts=temp;
                });

     },
}
}
</script>


