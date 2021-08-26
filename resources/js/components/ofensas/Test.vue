<template>

</template>

<script>
export default {
    created() {

    // this.creaChart();
    this.topOffenseCategories();

  },
methods:{
    topOffenseCategories() {
        this.loading=true;
         //this.axios.defaults.headers.common['Range'] = 'items=0-9';

        this.axios
            .get(`/api/top-ofenses-categories`)
            .then(response => {
               //this.regla_136124=response.data;
               console.log(response.data);

            }).catch(err => console.log(err))
            .finally(() => {
               this.loading=false;
               //this.chartOptionsOffenseCategories.series.push({name:this.CELEPSA[0].nombre,data:[this.regla_136124.length]})


            });

     },
}
}
</script>


