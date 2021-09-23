<template>
    <v-container fill-height fluid>
        <v-row align="center" justify="center">
            <v-col>
                <v-card elevation="4" class="mx-auto">
                    <v-card-title
                        class="d-flex justify-space-between"
                    >&nbsp;
                        <v-btn
                            v-if="!$store.state.auth"
                            class="mx-2"
                            dark
                            color="primary"
                            link
                            :to="'/login'"
                            >Iniciar Sesión
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                            <table>
                                <tr>
                                    <td>
                                <v-img
                                    src="../img/nuevologo-radical.png"
                                    alt="Logo"
                                    width="200"
                                ></v-img>
                                    </td>
                                    <td>
                                         <h2>IBM QRadar Rest API</h2>
                                        <p>
                                    Puede acceder a la API RESTful enviando solicitudes HTTPS a URL específicas (puntos finales) en QRadar SIEM Console. Para enviar estas solicitudes, utilice la implementación HTTP que está integrada en el lenguaje de programación de su elección. Cada solicitud contiene información de autenticación y parámetros que modifican la solicitud.
                                </p>
                                <p >
                                    An API endpoint contains the URL of the resource that you want to access and the action that you want to complete on that resource. The action is indicated by the HTTP method of the request: GET, POST, PUT, or DELETE.
                                </p>
                                Version 1.0
                                <a
                                    href="https://www.gruporadical.com/"
                                    target="_blank"
                                    >Grupo Radical</a
                                >
                                &copy;{{ new Date().getFullYear() }}. Todos los
                                derechos reservados
                                    </td>
                                    <td>
                                        <v-img
                                    src="../img/IBM-QRadar.png"
                                    alt="Logo"
                                    width="200"
                                ></v-img>
                                    </td>
                                </tr>
                            </table>
                        <v-row >
                            <v-col cols="12" >
                                <v-carousel
                                    cycle
                                    height="400"
                                    hide-delimiter-background
                                    show-arrows-on-hover
                                >
                                    <v-carousel-item
                                    v-for="(slide, i) in slides"
                                    :key="i"
                                    >
                                    <v-sheet
                                        :color="colors[i]"
                                        height="100%"
                                        elevation="4"
                                        :class="`rounded-lg`"
                                    >
                                        <v-row
                                        class="fill-height"
                                        align="center"
                                        justify="center"
                                        >
                                        <div class="text-center">
                                            <h3 class="display-3">
                                                <v-icon x-large style="font-size:50px">
                                                    {{ slide.icon }}
                                                </v-icon>
                                                    {{ slide.title }}
                                            </h3>
                                            <p>
                                                {{ slide.subtitle }}
                                            </p>
                                            <v-btn color="dark"
                                                    link :to="slide.link" >
                                                Ir
                                            </v-btn>
                                        </div>

                                        </v-row>
                                    </v-sheet>
                                    </v-carousel-item>
                                </v-carousel>

                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>

  export default {
    data() {
      return {
          overlay: false,
          slides: [
                {
                    title: 'Visualizacion de ofensas',
                    subtitle: 'Contabilizado de ofensas según el caso de uso',
                    icon:'mdi-account-multiple',
                    link: '/ofensas'
                },
                {
                    title: 'Overview',
                    subtitle: 'Información destacada de sus activos de seguridad',
                    icon:'mdi-face',
                    link: '/ofensas-overview'
                },
                {
                    title: 'Visualización de activos',
                    subtitle: 'Un listado de sus activos integrados',
                    icon:'mdi-book',
                    link: '/assets'
                },
          ],
          colors: [
          'light-blue lighten-3',
          'light-green lighten-3',
          'orange lighten-3',
        ],
      }
    }
  }

  </script>
