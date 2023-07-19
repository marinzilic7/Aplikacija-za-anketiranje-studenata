


<template>
    <div class="container mt-5 w-25">
        <div class="border-round p-5 bg-light">
            <form @submit.prevent="regUser" method="POST">
                <input type="hidden" v-model="this.POST" />
                <input type="hidden" name="" v-model="this.csrfToken" />
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" v-model="form.name">
                    <label for="floatingInput">Ime</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" v-model="form.lastName">
                    <label for="floatingInput">Prezime</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" v-model="form.email">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" v-model="form.password">
                    <label for="floatingPassword">Šifra</label>
                </div>
                <div class="form-floating ">
                    <input type="password" class="form-control" id="floatingPassword" v-model="form.passwordConf">
                    <label for="floatingPassword">Ponovi šifru</label>
                </div>
                <button class="btn btn-primary w-100 mt-4">Registriraj se</button>
            </form>

        </div>

    </div>
</template>

<script>
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
        }
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
                passConf: this.form.passwordConfirmation,
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
                        passwordConfirmation: "",
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
