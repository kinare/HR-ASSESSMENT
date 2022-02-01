import Vue from "vue";
import Vuetify from "vuetify";
import 'vuetify/dist/vuetify.min.css';
import colors from "vuetify/lib/util/colors";

Vue.use(Vuetify);

const opts = {
    theme: {
        themes: {
            light: {
                primary: colors.orange,
                secondary: colors.grey.darken1,
                accent: colors.pink.darken1,
                error: colors.red.accent3,
                background: colors.grey.lighten3,
                info: colors.teal.darken1,
                landingBackground: colors.grey.lighten3,
            },
            dark: {
                primary: colors.green,
                secondary: colors.grey.darken1,
                accent: colors.pink.darken1,
                background: "#121212",
            },
        },
    },
};

export default new Vuetify(opts);
