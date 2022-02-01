import Vue from "vue";
import router from "./router";
import store from "./store";
import  vuetify from  "./plugins/vuetify";
import { loader } from "./plugins"

Event = new Vue();

Vue.use(loader)

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify,
})
