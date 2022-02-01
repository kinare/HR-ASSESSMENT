import call from "../../service/http";
import { AuthConstants as constant, AuthService } from "./index";

export default {
    namespaced: true,
    state: {
        loading: false,
        isLogin: true,
        error: "",
        message: "",
        token: "",
        isModal: false,
        success: {
            title: "",
            message: "",
            action_label: "",
            to: ""
        }
    },
    mutations: {
        SET_ERROR: (state, payload) => {
            state.error = payload;
        },

        SET_SUCCESS: (state, payload) => {
            state.success = { ...payload }
        },

        SET_IS_LOGIN: (state, payload) => {
            state.isLogin = payload
        }
    },
    getters: {
        user: () => AuthService.user,
        loading: state => state.loading,
        token: state => state.token,
        error: state => state.error,
        message: state => state.message,
        success: state => state.success,
        isLogin: state => state.isLogin,
        isModal: state => state.isModal
    },
    actions: {

        login: (context, data) => {
            Event.$emit('loading', true);
            context.commit("SET_IS_LOGIN", true);
            context.commit("SET_ERROR", "");
            call("post", constant.login, data)
                .then(res => {
                    AuthService.login(res.data.data.token, res.data.data.user);
                    Event.$emit('loading', false);
                })
                .catch(err => {
                    context.commit("SET_ERROR", err.response.data.message);
                    Event.$emit('loading', false);
                });
        },

        forgotPassword: (context, data) => {
            context.commit("SET_ERROR", "");
            Event.$emit('loading', true);
            call("post", constant.passwordReset, data)
                .then(res => {
                    Event.$emit('loading', false);
                    context.commit('SET_SUCCESS', {
                        title: "Success",
                        message: `We have sent a password reset link to your email`,
                        action_label: "Home",
                        to: "/"
                    })

                    Event.$emit('auth-success')
                })
                .catch(err => {
                    context.commit("SET_ERROR", err.response.data.message);
                    Event.$emit('loading', false);
                });
        },

        resetPassword: (context, data) => {
            context.commit("SET_ERROR", "");
            Event.$emit('loading', true);
            call("post", constant.password, data)
                .then(res => {
                    Event.$emit('loading', false);
                    context.commit('SET_SUCCESS', {
                        title: "Success",
                        message: `Your password has been reset successfully`,
                        action_label: "Login to continue",
                        to: "/"
                    })

                    Event.$emit('auth-success')
                })
                .catch(err => {
                    context.commit("SET_ERROR", err.response.data.message);
                    Event.$emit('loading', false);
                });
        },

        user: context => {
            call("get", constant.user).then(res => {
                AuthService.setUser(res.data.data);
                Event.$emit('user', res.data.data);
            });
        },

        logout: context => {
            Event.$emit('loading', true);

            call("get", constant.logout).then(() => {
                AuthService.logout();
                Event.$emit('loading', false);
            }).catch(() =>{
                AuthService.logout();
                Event.$emit('loading', false);
            })
        },

        reset: () => {
            call("get", constant.reset).then(() => {
                AuthService.logout();
            }).catch(() =>{
                AuthService.logout();
                Event.$emit('loading', false);
            })
        },
    }
};
