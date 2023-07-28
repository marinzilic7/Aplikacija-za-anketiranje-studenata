<template>
    <div class="my-component">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-md-8 offset-md-3 col-lg-6 offset-lg-3">
                    <div class="border-round p-5 bg-light">
                        <form @submit.prevent="logUser" method="POST">
                            <input type="hidden" :value="this.POST" />
                            <input type="hidden" :value="this.csrfToken" />

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
                            <div v-if="successRegg" class="mt-3">
                                <p class="alert alert-success">
                                    Uspjesna prijava!
                                </p>
                            </div>

                            <div v-if="falseReg" class="mt-3">
                                <p class="alert alert-danger">
                                    Pogresan email ili lozinka
                                </p>
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
            logMessage: "",
            falseReg: false,
            successRegg: false,
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
                    this.logMessage = response.data.poruka;

                    console.log(this.logMessage);
                    this.successRegg = true;
                    if (this.logMessage == "Uspješna prijava") {
                        this.successRegg = true;
                        this.falseReg = false;
                        this.$router.push("/")
                    } else {
                        this.falseReg = true
                        this.successRegg = false;
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

<style scoped></style>
