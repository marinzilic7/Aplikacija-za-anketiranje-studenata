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
                                    :type="showPassword ? 'text' : 'password'"
                                    class="form-control"
                                    id="floatingPassword"
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
import { mapActions } from "vuex";
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
            showPassword:false,
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

                    this.successRegg = true;
                    if (this.logMessage == "Uspješna prijava") {
                        this.$store.dispatch(
                            "setLoginMessage",
                            this.logMessage
                        );
                        this.$store.commit(
                            "setLoggedInUser",
                            response.data.user
                        );
                        this.successRegg = true;
                        this.falseReg = false;
                        this.$router.push("/");
                    } else {
                        this.falseReg = true;
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

        showPasswordIcon() {
            this.showPassword = !this.showPassword;
        },
    },
    ...mapActions(["setLoginMessage"]),
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
