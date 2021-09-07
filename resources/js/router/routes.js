import VueRouter from 'vue-router';
import store from '../store/store';
import Register from "../components/auth/Register.vue";
import Login from "../components/auth/Login.vue";
import Home from "../components/Home.vue";

import AllUsuarios from "../components/usuario/AllUsuarios.vue";
import Ofensas from "../components/ofensas/List.vue";
import Assets from "../components/ofensas/Assets.vue";
import OfensasOverview from "../components/ofensas/Overview.vue";
import Extra from "../components/ofensas/Extra.vue";
//REPORTES

const router = new VueRouter({
    mode: "history",
    routes: [
        { path: "*", redirect: "/" },
        {
            name: "home",
            path: "/",
            component: Home,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/register",
            name: "register",
            component: Register,
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            meta: {
                requiresAuth: false
            }
        },
        {
            name: "usuarios",
            path: "/usuarios",
            component: AllUsuarios,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "extra",
            path: "/extra",
            component: Extra,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/ofensas",
            name: "Ofensas",
            component: Ofensas,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/ofensas-overview",
            name: "Ofensas-overview",
            component: OfensasOverview,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/assets",
            name: "assets",
            component: Assets,
            meta: {
                requiresAuth: true
            }
        },
    ]
});

router.beforeEach( (to, from, next) => {
    if (  to.matched.some(record => record.meta.requiresAuth)) {

            if ( store.state.auth) {
                return next()
            } else
            next('/login')
        } else {
            next()
        }
    })

export default router
