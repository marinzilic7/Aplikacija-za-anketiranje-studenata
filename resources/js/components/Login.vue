<template>
    <div class="my-component">
        <div class="container mt-5 ">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-3 col-lg-6  offset-lg-3 ">
                <div class="border-round p-5 bg-light ">
                    <form @submit.prevent="logUser" method="POST">
                        <input type="hidden" v-model="this.POST" />
                        <input type="hidden" name="" v-model="this.csrfToken" />

                        <div class="form-floating mb-3">
                            <input
                                type="email"
                                class="form-control"
                                id="floatingInput"
                                v-model="form.email"
                            />
                            <label for="floatingInput">Email address</label>
                            <p v-if="errors.email" class="text-danger">
                                {{ errors.email[0] }}
                            </p>
                        </div>
                        <div class="form-floating mb-3">
                            <input
                                type="password"
                                class="form-control"
                                id="floatingPassword"
                                v-model="form.password"
                            />
                            <label for="floatingPassword">Šifra</label>
                            <p v-if="errors.password" class="text-danger">
                                {{ errors.password[0] }}
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100 mt-4"
                        >
                            Prijavi se
                        </button>
                        <div
                            v-if="successReg"
                            class="alert alert-success mt-3"
                            role="alert"
                        >
                            {{ poruka }} <a href="/login">Prijava</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</template>

<script>
import axios from "axios";
import router from "../router";
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            errors: {},
            csrfToken: "",
            POST: "",
            loginMessage:"",
        };
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
        logUser() {
            const Data = {
                email: this.form.email,
                password: this.form.password,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/logUser", Data)
                .then((response) => {
                    this.loginMessage = response.data.poruka;
                    console.log(this.loginMessage)
                    if(this.loginMessage === "Uspjesna prijava"){
                        this.$router.push({path: "/"});
                    }
                })
                .catch((error) => {
                    console.log("Error:", error);
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
    },
};
</script>

<style scoped>



</style>
