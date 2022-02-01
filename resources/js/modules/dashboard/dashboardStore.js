import _ from "lodash";
import dashboardConstants from "./dashboardConstants";
import { call } from "../../service";
export default {
    namespaced: true,
    state: {
        loading: false,
        alert: {
        status: '',
        message: "",
        },
        policies: [],
        assessments: [],
        scale: [],
    },
    mutations: {
        SET_LOADING: (state, payload) => {
        state.loading = payload;
        },

        SET_ALERT: (state, payload) => {
        state.alert = payload ? { ...payload } : { status: '', message: "",};
        },

        SET_ASSESSMENTS: (state, payload) => {
          state.assessments = payload
        },

        SET_SCALE: (state, payload) => {
          state.scale = payload
        },

        SET_POLICIES: (state, payload) => {
          state.policies = payload
        },
    },

    getters: {
        loading: (state) => state.loading,
        alert: (state) => state.alert,
        assessments: (state) => state.assessments,
        scale: (state) => state.scale,
        policies: (state) => state.policies,
    },

    actions: {

        getAssessments: ({ commit }) => {
            commit('SET_LOADING', true);
            commit('SET_ALERT',null);
            call("get", dashboardConstants.assessments).then((res) => {
                commit('SET_ASSESSMENTS', res.data);
                commit('SET_LOADING', false);
            }).catch((err) => {
                commit('SET_LOADING', false);
                commit('SET_ALERT', { status: 'error', message: err.response.data.message });
            });
        },

        getPolicies: ({ commit }) => {
            commit('SET_LOADING', true);
            commit('SET_ALERT',null);
            call("get", dashboardConstants.policies).then((res) => {
                commit('SET_POLICIES', res.data);
                commit('SET_LOADING', false);
            }).catch((err) => {
                commit('SET_LOADING', false);
                commit('SET_ALERT', { status: 'error', message: err.response.data.message });
            });
        },

        getScales: ({ commit }) => {
            commit('SET_LOADING', true);
            commit('SET_ALERT',null);
            call("get", dashboardConstants.scales).then((res) => {
                commit('SET_SCALE', res.data);
                commit('SET_LOADING', false);
            }).catch((err) => {
                commit('SET_LOADING', false);
                commit('SET_ALERT', { status: 'error', message: err.response.data.message });
            });
        },

        submitAssessment: ({ commit, dispatch }, data) => {
            commit('SET_LOADING', true);
            commit('SET_ALERT',null);
            call("post", dashboardConstants.assessments, data).then((res) => {
                dispatch('getAssessments');
                Event.$emit('submitted')
                commit('SET_LOADING', false);
            }).catch((err) => {
                commit('SET_LOADING', false);
                commit('SET_ALERT', { status: 'error', message: err.response.data.message });
            });
        },
    },
};
