


<template>
    <div class="container mt-5 w-25">
        <div class="border-round p-5 bg-light">
            <form @submit.prevent="regUser" method="POST">
                <input type="hidden" v-model="this.POST" />
                <input type="hidden" name="" v-model="this.csrfToken" />
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" v-model="form.name">
                    <label for="floatingInput">Ime</label>
                    <p v-if="errors.name" class="text-danger">
                        {{ errors.name[0] }}
                    </p>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" v-model="form.lastName">
                    <label for="floatingInput">Prezime</label>
                    <p v-if="errors.lastName" class="text-danger">
                        {{ errors.lastName[0] }}
                    </p>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" v-model="form.email">
                    <label for="floatingInput">Email address</label>
                    <p v-if="errors.email" class="text-danger">
                        {{ errors.email[0] }}
                    </p>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" v-model="form.password">
                    <label for="floatingPassword">Šifra</label>
                    <p v-if="errors.password" class="text-danger">
                        {{ errors.password[0] }}
                    </p>
                </div>
                <div class="form-floating ">
                    <input type="password" class="form-control" id="floatingPassword" v-model="form.passwordConf">
                    <label for="floatingPassword">Ponovi šifru</label>
                    <p v-if="errors.passwordConf" class="text-danger">
                        {{ errors.passwordConf[0] }}
                    </p>
                </div>
                <button type="submit"  class="btn btn-primary w-100 mt-4">Registriraj se</button>
                <div v-if="successReg" class="alert alert-success mt-3" role="alert">
                    {{poruka}}
                </div>
            </form>

        </div>

    </div>
</template>

<script>

import axios from "axios";
export default {
    data() {
        return {
            form: {
                name: "",
                lastName: "",
                email: "",
                password: "",
                passwordConf: ""

            },
            csrfToken: "",
            POST: "",
            errors: {},
            successReg:false,
            poruka:"",
        }
    },
    mounted() {
        // Pozovite fetchCsrfToken() u metodi mounted()
        this.fetchCsrfToken();
    },
    methods: {
        fetchCsrfToken() {
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    this.csrfToken = response.data.csrf_token;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        regUser() {
            const Data = {
                name: this.form.name,
                lastName: this.form.lastName,
                email: this.form.email,
                password: this.form.password,
                passwordConf: this.form.passwordConf,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/regUser", Data)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.successReg = true;
                    this.form = {
                        name: "",
                        lastName: "",
                        email: "",
                        password: "",
                        passwordConf: "",
                    };
                    this.errors = {};
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
    }
}
</script>

<style scoped>

</style>
