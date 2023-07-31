<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <nav class="navbar navbar-expand-lg bg-dark col-sm-12 col-md-12 shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="#">AnketaApp</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <RouterLink class="text-light homeLink" to="/"
                            >Home</RouterLink
                        >
                    </li>

                </ul>
                <ul class="navbar-nav ms-auto regDetails">
                    <div class="row">
                        <li
                            v-if="!isLoggedIn"
                            class="nav-item class col-12 d-flex flex-column col-sm-12 flex-sm-column justify-content-sm-center d-md-flex col-md-12 flex-md-row logItems"
                        >
                            <RouterLink class="text-light pe-3" to="/login"
                                >Prijava</RouterLink
                            >
                            <RouterLink class="text-light" to="/register"
                                >Registracija</RouterLink
                            >
                        </li>
                        <li v-else>
                            <div class="dropdown">
                                <button
                                    class="btn btn-dark dropdown-toggle"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ loggedInUser.name }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button
                                            @click="logOut"
                                            class="dropdown-item"
                                            type="button"
                                        >
                                            Logout
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <RouterView />
</template>

<script>

import { mapGetters } from "vuex";
export default {
    data() {
        return {
            isLoggedIn: false,


        };
    },
    computed: {
        ...mapGetters(["loggedInUser"]),
        isLoggedIn() {
            return this.loggedInUser !== null;
        },
    },
    created() {
        this.checkLoginStatus();
    },
    methods: {
        checkLoginStatus() {
            axios
                .get("/isLogged")
                .then((response) => {
                    this.loggedInUser = response.data;

                    this.isLoggedIn = true;
                    console.log(this.isLoggedIn);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        logOut() {
            axios
                .post("/logout")
                .then((response) => {
                    this.isLoggedIn = false;
                    this.loggedInUser = null;
                    this.$store.dispatch("logout");
                    this.$router.push("/login");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

    },
};
</script>

<style scoped>
.homeLink {
    text-decoration: none;
}

.logItems a {
    text-decoration: none;
}
</style>
