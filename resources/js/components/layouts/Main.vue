<template>
    <div>
        <v-app>


            <v-app-bar app dense >
                <div class="d-flex align-center">
                    <v-img
                    alt="Vuetify Logo"
                    class="shrink mr-2"
                    contain
                    src="../img/nuevologo-radical.png"
                    transition="scale-transition"
                    width="180"
                    />


                </div>
                 <v-btn text dark color="orange darken-4" link :to="'/ofensas'">
                    Ofenses
                </v-btn>
                <v-btn text dark color="orange darken-4" link :to="'/ofensas-overview'">
                    Overview
                </v-btn>
                <v-btn text dark color="orange darken-4" link :to="'/extra'">
                    Extra
                </v-btn>
                <!-- <v-btn text dark color="orange darken-4" link :to="'/assets'">
                    Assets
                </v-btn> -->

                <v-spacer></v-spacer>
                <v-chip
                class="ma-2" ><v-icon left>
        mdi-account-circle-outline
      </v-icon> {{ ($store.state.user.company) ? $store.state.user.company.description : 'NA' }}</v-chip>

                <v-btn icon  @click="logout">
                    <v-icon >mdi-logout</v-icon>
                </v-btn>
            </v-app-bar>

            <!-- Sizes your content based upon application components -->
            <v-main >
                <!-- Provides the application the proper gutter -->
                <v-container fluid>
                    <!-- If using vue-router -->
                    <router-view></router-view>
                </v-container>
            </v-main>

        </v-app>
    </div>
</template>
<script>
export default {
    data() {
        return {
            dialog: false,
            drawer: true,
            form: {
                old_password: null,
                new_password: null,
                new_password2: null
            },
            error: null,
            has_error: false,
            loading: false,
            valid: true,
            items: [
                {
                    title: "Actividades",
                    link: "/actividad",
                    icon: "mdi-table-search"
                },
                {
                    title: "Reportes",
                    icon: "mdi-chart-bar",
                    subLinks: [
                        // { title: "General", link: "/reporte-general", icon: "mdi-certificate"},
                        {
                            title: "Resumen",
                            link: "/reporte-resumen",
                            icon: "mdi-list"
                        },
                    ]
                },
                {
                    title: "Configuracion",
                    icon: "mdi-cogs",
                    subLinks: [
                        {
                            title: "Usuarios",
                            link: "/usuarios",
                            icon: "mdi-account-multiple"
                        },
                        { title: "Paises", link: "/paises", icon: "mdi-earth" },
                        {
                            title: "Certificaciones",
                            link: "/certificaciones",
                            icon: "mdi-certificate"
                        },
                        {
                            title: "Niveles",
                            link: "/nivel-estudio",
                            icon: "mdi-graph-outline"
                        }
                    ]
                }
            ],
            right: null
        };
    },
    methods: {
        logout() {
            this.$swal
                .fire({
                    title: "Esta seguro?",
                    html: `Finalizará su sesión`,
                    icon: "question",
                    showConfirmButton: true,
                    showCancelButton: true
                })
                .then(res => {
                    if (res.value) {
                        this.$store
                            .dispatch("logout")
                            .then(() => {
                                this.$router.push({ name: "login" });
                            })
                            .catch(() => []);
                        //this.$router.replace("/login");
                    }
                });
        },

    }
};
</script>
