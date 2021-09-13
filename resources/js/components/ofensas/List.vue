<template>
  <div>

    <v-row dense>
            <v-col v-for="regla in reglas" v-bind:key="regla.qid" cols="3" dense>
                 <v-hover v-slot="{ hover }">
                <v-card
                class="mx-auto"
                max-width="344"
                shaped
                :color="(regla.ofensas>0) ? 'red lighten-1' : 'green darken-2'"
                :elevation="hover ? 12 : 2"
              :class="{ 'on-hover': hover }"

            >
                <v-list-item

                    >
                    <v-list-item-content>
                    <div class="text-overline mb-4 text--secondary">
                    {{ regla.description }}
                    <v-chip x-small color="dark" dark label>{{ regla.it_ot }}</v-chip>
                    </div>
                    <v-list-item-title class="text-h1 mb-1">
                        <v-progress-linear
                            indeterminate
                            color="black" v-if="regla.loading"
                            class="display-4 text-center font-weight-bold"
                            ></v-progress-linear>
                    <h1 v-else class="display-3 text-center font-weight-bold" >{{regla.ofensas}}</h1>
                    </v-list-item-title>
                    <v-list-item-subtitle></v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>

                <v-card-actions>

                </v-card-actions>
            </v-card>
                 </v-hover>
            </v-col>


    </v-row>
    <v-row v-show="chartOptions.series.length>0" dense>
       <v-col cols="12" dense>
          <v-card>
       <v-card-text>
            <highcharts :options="chartOptions" ></highcharts>
       </v-card-text>
    </v-card>
       </v-col>
    </v-row>

  </div>
</template>

<script>
// @ is an alias to /src

export default {

  name: "Ofensas",
  data() {
     return {
        loading:false,
        ofensas:[],
        reglas:[],
         chartOptions: {
        chart: {
          type: 'column'
        },
        title: {
          text: 'Cantidad de Ofensas por caso de uso'
        },
        series: [ ],
        yAxis:{
               title:{
                  text:'Ofensas'
               }
            },
        xAxis:{
                categories:['Caso de Uso']
            },
      },

     }
  },
   mounted() {

      },
  created() {
      this.getReglas()

  },
  methods:{




     getReglas(){
         this.axios
                .get('/api/rules')
                .then(response => {
                    this.reglas = response.data;
                    console.log(response.data);
                    this.reglas.forEach(element => {
                        element.loading=true;
                        this.axios
                                .get(`/api/offenses-rule/${element.qid}`)
                                .then(resp => {
                                    console.log(resp.data.length);
                                    element.ofensas = resp.data.length;
                                    element.loading=false;

                                    this.chartOptions.series.push({name:element.description,data:[resp.data.length]})
                                }).catch(err => console.log(err))
                                .finally(() => {


                                });
                                console.log(this.reglas);
                    });
                });
     },


  }

};
</script>
