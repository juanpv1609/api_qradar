<template>
    <v-container fill-height fluid>
        <v-row align="center" justify="center" class="pa-10">
            <v-col>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card
                        elevation="8"
                        :loading="loading"
                        class="m-auto "
                        max-width="400"
                    >
                        <v-card-text>
                            <v-img
                                src="../img/nuevologo-radical.png"
                                alt="Logo"
                            ></v-img>
                            <v-divider></v-divider>
                            <h2 class="text-center">Iniciar Sesión</h2>
                            <v-col cols="12" dense>
                                <v-text-field
                                    label="Usuario*"

                                    v-model="form.email"
                                    required
                                    type="email"
                                    :rules="emailRules"
                                    prepend-inner-icon="mdi-account"
                                    outlined
                                    dense
                                    color="orange darken-4"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" dense>
                                <v-text-field
                                    label="Contraseña*"

                                    v-model="form.password"
                                    required
                                    outlined
                                    dense
                                    color="orange darken-4"
                                    :rules="passwordRules"
                                    @keyup.enter="login"
                                    :type="show ? 'text' : 'password'"
                                    :append-icon="
                                        show ? 'mdi-eye' : 'mdi-eye-off'
                                    "
                                    @click:append="show = !show"
                                    prepend-inner-icon="mdi-lock"
                                ></v-text-field>
                            </v-col>
                            <v-alert
                                v-if="has_error"
                                color="red"
                                type="error"
                                >{{ error }}</v-alert
                            >
                            <v-col cols="12">
                                <v-btn
                                block
                                dark
                                color="orange darken-4"
                                depressed
                                @click="login"
                            >
                                Enviar
                            </v-btn>
                            </v-col>
                        </v-card-text>
                    </v-card>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
export default {
    data() {
        return {
            show: false,
            valid: true,
            loading: false,
            form: {
                email: null,
                password: null
            },
            has_error: false,
            error: null,
            emailRules: [
                v => !!v || "Username is required",
                //v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
            passwordRules: [
                v => !!v || "Password is required"
                //v => (v && v.length >= 6) || 'Name must be less than 6 characters',
            ]
        };
    },
    created() {
        this.$store.commit("SET_LAYOUT", "auth-layout");
    },
    methods: {
        login() {
            this.axios.defaults.baseURL = process.env.MIX_APP_URL;
            if (this.$refs.form.validate()) {
                this.loading = true;
                this.$store
                    .dispatch("login", this.form)
                    .then(() => {
                        this.loading = false;
                        //this.$router.push({ path: this.redirect || "/contratos" }, () => { }, () => { });
                        this.$router
                            .push({ name: "Ofensas-overview" })
                            .then(() => {
                                this.$store.commit("SET_LAYOUT", "main-layout");
                            })
                            .catch(() => []);
                    })
                    .catch(error => {
                        this.loading = false;
                        if (error.response) {
                            this.has_error = true;
                            this.error = error.response.data.errors.email[0];
                        }
                    });
            }

            //redirect
        }
    }
};
</script>
