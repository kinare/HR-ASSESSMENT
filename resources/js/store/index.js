import Vue from "vue";
import Vuex from "vuex";
import { AuthStore } from "../modules/auth";
import { DashboardStore } from "../modules/dashboard";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Auth: AuthStore,
        Dashboard: DashboardStore
    },
    state: {},
    getters:{},
})
