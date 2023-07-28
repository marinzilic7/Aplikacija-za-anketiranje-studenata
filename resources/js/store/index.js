import { createStore } from 'vuex';

const store = createStore({
    state() {
        return {
            loginMessage: '',
            isLoggedIn: false,
            loggedInUser: null,
        };
    },
    mutations: {
        setLoginMessage(state, message) {
            state.loginMessage = message;
        },
        clearLoginMessage(state) {
            state.loginMessage = '';
        },
        setLoggedInUser(state, user) {
            state.loggedInUser = user;
        },
        setIsLoggedIn(state, isLoggedIn) {
            state.isLoggedIn = isLoggedIn;
        },
    },
    actions: {
        setLoginMessage({ commit }, message) {
            commit('setLoginMessage', message);
        },
        clearLoginMessage({ commit }) {
            commit('clearLoginMessage');
        },
        login({ commit }, user) {
            // Ovdje bismo pozvali API za prijavu korisnika
            // Kada dobijemo uspješan odgovor od servera, ažuriramo Vuex stanje
            commit("setLoggedInUser", user);
            commit("setIsLoggedIn", true);
          },
          logout({ commit }) {
            // Ovdje bismo pozvali API za odjavu korisnika
            // Kada dobijemo uspješan odgovor od servera, ažuriramo Vuex stanje
            commit("setLoggedInUser", null);
            commit("setIsLoggedIn", false);
          },
    },
    getters: {
        loggedInUser(state) {
          return state.loggedInUser;
        },
        isLoggedIn(state) {
          return state.isLoggedIn;
        },
      },
});

export default store;
