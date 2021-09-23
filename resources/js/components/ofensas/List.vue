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
                    @click="detalle(regla)"
                    >
                    <v-list-item-content>
                    <div class="text-overline mb-4 text--secondary"  >
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

                <v-fab-transition>
      <v-btn
        color="primary"
        fab
        large
        dark
        bottom
        left
      >
        <v-icon>mdi-reload</v-icon>
      </v-btn>
    </v-fab-transition>
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
<template>
        <v-row justify="center">
            <v-dialog v-model="dialog" fullscreen
                hide-overlay
                transition="dialog-bottom-transition"
                >
                <v-card style="background:#F5F5F5;">
                    <v-toolbar
                        dark
                        color="dark"
                        >
                        <v-btn
                            icon
                            dark
                            @click="cerrar()"
                        >
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title>{{ titleForm }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn
                            dark
                            text
                            @click="cerrar()"
                            >
                            Cerrar
                            </v-btn>
                        </v-toolbar-items>
                        </v-toolbar>
                        <br>
                    <v-card-text>

                            <v-row v-show="chartObjeto.series.length>0" dense>
                                <v-col cols="12" dense>
                                    <v-card>
                                <v-card-text>
                                        <highcharts :options="chartObjeto" ></highcharts>
                                </v-card-text>
                                </v-card>
                                </v-col>
                                </v-row>
                                <v-row>
                                    <v-card>
                                            <v-card-title
                                        >
                                            Ofensas
                                            <v-spacer></v-spacer>
                                            <v-col cols="auto">
                                                <v-text-field
                                                v-model="searchObjetos"
                                                append-icon="mdi-magnify"
                                                label="Buscar"
                                                single-line
                                                hide-details
                                                filled
                                                rounded
                                                dense
                                            ></v-text-field>
                                            </v-col>

                                            </v-card-title>
                                    <v-card-text>
                                    <v-data-table

                                            :headers="headersObjetos"
                                            :items="objetos"
                                            :search="searchObjetos"
                                            :items-per-page="10"
                                        >
                                        <template v-slot:item="row">
                                            <tr>
                                                <td>{{row.item.description}}</td>
                                                 <!-- <td>{{row.item.categories}}</td> -->
                                                 <td>
                                                     <div v-for="cat in row.item.categories" v-bind:key="cat">
                                                         <v-chip small class="ma-1" color="primary">{{cat}}</v-chip>
                                                         </div>
                                                         </td>
                                                         <td>
                                                     <div v-for="log in row.item.log_sources" v-bind:key="log.id">
                                                         <v-chip small class="ma-1">{{log.name}}</v-chip>
                                                         </div>
                                                         </td>
                                                <td>{{row.item.event_count}}</td>
                                                <td>{{row.item.offense_source}}</td>
                                                <td>{{row.item.start_time}} | {{row.item.last_persisted_time}}</td>
                                                <td>{{row.item.magnitude}}</td>

                                            </tr>
                                        </template>
                                </v-data-table>
                                    </v-card-text>
                                    </v-card>
                                </v-row>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-row>
    </template>
  </div>
</template>

<script>
// @ is an alias to /src
import moment from 'moment';
export default {

  name: "Ofensas",
  data() {
     return {
        loading:false,
        dialog: false,
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
      chartObjeto: {
        chart: {
          type: 'bar'
        },
        title: {
          text: 'Detalle'
        },
        series: [ ],

      },
      objeto:{},
      objetos:[],
         searchObjetos: "",
            headersObjetos: [
                 { text: "Descripción", value: "description" },
                  // { text: "Network", value: "network" },
                 { text: "Categorias", value: "categories" },
                 { text: "LogSources", value: "log_sources" },
                 { text: "Eventos", value: "event_count" },
                 { text: "Origen ofensa", value: "offense_source" },
                 { text: "Start / Last (Time)", value: "offense_source" },
                 { text: "Magnitud", value: "magnitude" },
            ],

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
                                    element.ofensas = resp.data.length;
                                    element.event_count=0;
                                    element.ofensas_count=resp.data.length;
                                    element.category_count=0;
                                    element.categories='';
                                    element.log_sources=0;
                                    element.destination_networks='';
                                    element.elementos=[];
                                    resp.data.forEach(r => {
                                        element.event_count=element.event_count+r.event_count
                                        element.category_count=element.category_count+r.category_count
                                        element.categories= element.categories+ r.categories
                                        element.log_sources= element.log_sources+r.log_sources.length;
                                        element.destination_networks= element.destination_networks+ r.destination_networks;
                                        element.start_time=(element.start_time);
                                        element.last_persisted_time=(element.last_persisted_time);

                                        element.elementos.push(r);

                                    })
                                    element.loading=false;

                                    this.chartOptions.series.push({name:element.description,data:[resp.data.length]})
                                }).catch(err => console.log(err))
                                .finally(() => {


                                });
                                //console.log(this.reglas);
                                    //console.log(this.objetos);

                    });
                });
     },
     detalle(el){
         console.log(el);
        //var total= el.event_count + el.ofensas_count +el.category_count + el.log_sources;
         this.titleForm = el.description;
        this.objeto.event_count=el.event_count;
        this.objeto.ofensas_count=el.ofensas_count;
        this.objeto.category_count=el.category_count;
        this.objeto.categories=el.categories;
        this.objeto.log_sources=el.log_sources;
        this.objeto.destination_networks=el.destination_networks;
        this.objeto.elementos=el.elementos;
        this.objeto.start_time=moment(el.start_time).format("DD/MM/YYYY hh:mm");
        this.objeto.last_persisted_time=moment(el.last_persisted_time).format("DD/MM/YYYY hh:mm");
        this.objetos=el.elementos


        this.chartObjeto.series.push({name:'Eventos',data:[(el.event_count)]})
        this.chartObjeto.series.push({name:'Ofensas',data:[(el.ofensas_count)]})
        this.chartObjeto.series.push({name:'Categorias',data:[(el.category_count)]})
        this.chartObjeto.series.push({name:'LogSources',data:[(el.log_sources)]})

         this.dialog=true;

     },
     cerrar(){
         this.chartObjeto.series=[];
         this.objeto={};
         this.dialog = false;
     }


  }

};
</script>
