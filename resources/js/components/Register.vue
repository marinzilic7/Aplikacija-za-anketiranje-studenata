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
                        <div class="form-floating mb-3 d-flex">
                            <input
                                :type="showPassword ? 'text' : 'password'"
                                class="form-control"
                                id="passwordInput"
                                v-model="form.password"
                            />
                            <span @click="showPasswordIcon">
                                <svg
                                    v-if="!showPassword"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="19"
                                    height="19"
                                    fill="currentColor"
                                    class="bi bi-eye-slash-fill hiddenEye"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"
                                    />
                                    <path
                                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"
                                    />
                                </svg>
                                <svg
                                    v-else="showPassword"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="19"
                                    height="19"
                                    fill="currentColor"
                                    class="bi bi-eye-fill hiddenEye"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"
                                    />
                                    <path
                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"
                                    />
                                </svg>
                            </span>

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
                        <p
                            class="info"
                            v-if="form.password !== ''"
                            :style="passwordInfoStyle"
                        >
                            {{ passwordInfo }}
                        </p>
                        <p v-if="errors.password" class="text-danger">
                            {{ errors.password[0] }}
                        </p>
                        <div class="form-floating mt-3">
                            <input
                                :type="showPasswordConf ? 'text' : 'password'"
                                class="form-control"
                                id="floatingPassword"
                                v-model="form.passwordConf"
                            />
                            <span @click="showPasswordIconConf">
                                <svg
                                    v-if="!showPasswordConf"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="19"
                                    height="19"
                                    fill="currentColor"
                                    class="bi bi-eye-slash-fill hiddenEye"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"
                                    />
                                    <path
                                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"
                                    />
                                </svg>
                                <svg
                                    v-else="showPasswordConf"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="19"
                                    height="19"
                                    fill="currentColor"
                                    class="bi bi-eye-fill hiddenEye"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"
                                    />
                                    <path
                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"
                                    />
                                </svg>
                            </span>
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
            showPassword: false,
            showPasswordConf:false,
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
            } else if (strength < 80) {
                return { color: "orange" };
            } else {
                return { color: "green" };
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

        showPasswordIcon() {
            this.showPassword = !this.showPassword;
        },
        showPasswordIconConf() {
            this.showPasswordConf = !this.showPasswordConf;
        },
    },
};
</script>

<style scoped>
.hiddenEye {
    position: absolute;
    right: 0.8rem;
    top: 1.2rem;

    cursor: pointer;
}
</style>
