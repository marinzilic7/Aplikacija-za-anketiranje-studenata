<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <div class="border-round p-5 bg-light">
                    <form @submit.prevent="regUser" method="POST">
                        <input type="hidden" v-model="this.POST" />
                        <input type="hidden" name="" v-model="this.csrfToken" />
                        <div class="form-floating mb-3">
                            <input
                                type="text"
                                class="form-control"
                                id="floatingInput"
                                v-model="form.name"
                            />
                            <label for="floatingInput">Ime</label>
                            <p v-if="errors.name" class="text-danger">
                                {{ errors.name[0] }}
                            </p>
                        </div>
                        <div class="form-floating mb-3">
                            <input
                                type="text"
                                class="form-control"
                                id="floatingInput"
                                v-model="form.lastName"
                            />
                            <label for="floatingInput">Prezime</label>
                            <p v-if="errors.lastName" class="text-danger">
                                {{ errors.lastName[0] }}
                            </p>
                        </div>
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
                                id="passwordInput"
                                v-model="form.password"
                            />
                            <label for="floatingPassword">Šifra</label>
                        </div>
                        <div class="progress" v-if="form.password !== ''">
                            <div
                                class="progress-bar"
                                role="progressbar"
                                aria-valuenow="0"
                                aria-valuemin="0"
                                aria-valuemax="100"
                                :style="{ width: passwordStrength + '%' }"
                                :aria-valuenow="passwordStrength"
                                :class="passwordStrengthClass"
                            ></div>
                        </div>
                        <p class="info" v-if="form.password !== ''"  :style="passwordInfoStyle">
                            {{ passwordInfo }}
                        </p>
                        <p v-if="errors.password" class="text-danger">
                            {{ errors.password[0] }}
                        </p>
                        <div class="form-floating mt-3">
                            <input
                                type="password"
                                class="form-control"
                                id="floatingPassword"
                                v-model="form.passwordConf"
                            />
                            <label for="floatingPassword">Ponovi šifru</label>
                            <p v-if="errors.passwordConf" class="text-danger">
                                {{ errors.passwordConf[0] }}
                            </p>
                        </div>
                        <button
                            type="submit"
                            class="btn btn-primary w-100 mt-4"
                        >
                            Registriraj se
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
                passwordConf: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            successReg: false,
            poruka: "",
        };
    },
    beforeRouteLeave(to, from, next) {
        // Očistite progres bar prije nego što komponenta napusti rutu
        this.clearProgressBar();
        next();
    },
    mounted() {
        // Pozovite fetchCsrfToken() u metodi mounted()
        this.fetchCsrfToken();
        this.updateProgressBar();
    },
    computed: {
        passwordStrength() {
            return this.calculatePasswordStrength(this.form.password);
        },
        passwordStrengthClass() {
            if (this.passwordStrength < 50) {
                return "bg-danger";
            } else if (this.passwordStrength < 80) {
                return "bg-warning";
            } else {
                return "bg-success";
            }
        },
        passwordInfo() {
            if (this.passwordStrength < 50) {
                return "Weak";
            } else if (this.passwordStrength < 80) {
                return "Fine";
            } else {
                return "Strong";
            }
        },
        passwordInfoStyle() {
            // Dodajte svoju logiku za stil teksta o snazi lozinke ovdje
            const strength = this.passwordStrength;
            if (strength < 50) {
                return { color: "red" };
            }  else if (strength < 80) {
                return {color:"orange"}
            } else {
                return {color:"green"}
            }
        },
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
        clearProgressBar() {
            // Resetiranje progres bara
            this.form.password = "";
        },
        calculatePasswordStrength(password) {
            // Računanje jačine lozinke
            var strength = password.length * 10;
            strength = Math.min(strength, 100);
            return strength;
        },
        updateProgressBar() {
            // Dodajte ovaj dio kako biste ažurirali progres bar prilikom svakog unosa u polje šifre
            $("#passwordInput").on("input", () => {
                this.$forceUpdate(); // Ovo osvježava computed property passwordStrength
            });
        },
    },
};
</script>

<style scoped></style>
