<template>
    <div>
            <v-card elevation="2" :loading="loading">
                <v-card-title class="d-flex justify-space-between mb-6"
                    >
                    <v-badge
                :content="usuarios.length"
                :value="usuarios.length"
                color="green"

            >
            Usuarios
            </v-badge>
                    <v-btn
                        class="mx-2"
                        fab
                        dark
                        small
                        color="primary"
                        @click="addUser"
                    >
                        <v-icon dark>
                            mdi-plus
                        </v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-text>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                    <v-data-table
                        :headers="headers"
                        :items="usuarios"
                        :search="search"
                    >
                    <template v-slot:item="row">
                        <tr>
                            <td>{{row.item.id}}</td>
                            <td>{{row.item.username}}</td>
                            <td>{{row.item.email}}</td>
                            <td>{{row.item.rol.description}}</td>
                            <td>{{row.item.company.description}}</td>
                            <td>
                                <v-btn  icon color="primary" @click="editUser(row.item)">
                                    <v-icon dark>mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn :disabled="row.item.rol==1"  icon color="error" @click="deleteUser(row.item)">
                                    <v-icon dark>mdi-delete</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
        </v-data-table>
                </v-card-text>

                <v-card-actions> </v-card-actions>
            </v-card>
            <template>
                <v-row justify="center">
                    <v-dialog v-model="dialog" persistent max-width="400px">
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ titleForm }}</span>
                            </v-card-title>
                            <v-card-text>
                                    <v-row dense>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="usuario.username"
                                                label="Nombre de usuario*"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">

                                            <v-text-field
                                                v-model="usuario.email"
                                                label="Direccion de correo*"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-select :items="roles" v-model="usuario.rol_id"
                                                label="Rol">
                                            </v-select>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-autocomplete
                                                        :items="companies"
                                                        clearable
                                                        item-text="description"
                                                        item-value="id"
                                                        v-model="usuario.company_id"
                                                        label="Seleccione una compañia"
                                                        :rules="rules.company_id"
                                                        dense
                                                    ></v-autocomplete>
                                        </v-col>
                                        <v-col cols="12" v-if="!update">
                                            <v-text-field
                                                v-model="usuario.password"
                                                label="Password*"
                                                required
                                                type="password"

                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                <small>*indicates required field</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="error"
                                    text
                                    @click="dialog = false"
                                >
                                    Cerrar
                                </v-btn>
                                <v-btn
                                    v-if="!update"
                                    color="primary"
                                    text
                                    @click="createUser"
                                >
                                    Guardar
                                </v-btn>
                                <v-btn
                                    v-else
                                    color="primary"
                                    text
                                    @click="updateUser"
                                >
                                    Actualizar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
            </template>
    </div>

</template>

<script>
import moment from 'moment';
    export default {
        data() {
            return {
                usuarios: [],
                companies:[],
                dialog: false,
                update: false,
                usuario: {},
                loading: true,
                titleForm: null,
                rules:{
                        company_id: [ v => !!v || 'Este campo es requerido!' ],
                },
                search: "",

                roles:[
                    {
                        value:2,
                        text: 'Cliente'
                    },
                    {
                        value:1,
                        text: 'Adminstrador'
                    }
                ],
                headers: [
                {
                    text: "Id",
                    // align: 'start',
                    // filterable: false,
                    value: "id"
                },
                { text: "Username", value: "username" },
                { text: "Email", value: "email" },
                { text: "Rol", value: "rol" },
                { text: "Compañia", value: "company" },
                // { text: "Fecha creacion", value: "created_at" },
                { text: "Acciones", value: "controls", sortable: false }
            ]

            }
        },
        created() {
            this.getData();
        },
        methods: {
            getData(){
                this.axios
                .get('/api/usuarios-all')
                .then(response => {
                    this.usuarios = response.data;
                    console.log(response.data);
                    this.loading = false;
                });
                this.axios
                .get('/api/company')
                .then(response => {
                    this.companies = response.data;
                    console.log(response.data);
                    this.loading = false;
                });
            },
            addUser() {

                this.titleForm = "Nuevo Usuario";
                this.usuario = {};
                //this.usuario.password='R@dical2021';
                this.update = false;
                this.dialog = true;
            },
            editUser(el) {
                console.log(el);
                this.titleForm = "Editar Usuario";
                this.update = true;
                this.usuario.id = el.id;
                this.usuario.username = el.username;
                this.usuario.email = el.email;
                this.usuario.rol_id = el.rol.id;
                this.usuario.company_id = el.company.id;
                this.dialog = true;
            },
            createUser() {
                this.loading = true;
                this.axios
                    .post('/api/usuarios', this.usuario)
                    .then(() => {
                        this.dialog = false;
                        this.loading = false;
                        this.getData();
                         })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },
            updateUser() {
                this.loading = true;
                this.axios
                    .patch(`/api/usuarios/${this.usuario.id}`, this.usuario)
                    .then(() => {
                        this.dialog = false;
                        this.loading = false;
                        this.getData();
                    });
            },
            deleteUser(el) {
                this.loading = true;
                this.axios
                    .delete(`/api/usuarios/${el.id}`)
                    .then(response => {
                        let i = this.usuarios.map(data => data.id).indexOf(el.id);
                        this.usuarios.splice(i, 1);
                        this.loading = false;
                    });
            }
        }
    }
</script>
