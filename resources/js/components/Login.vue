<template>
    <div class="container mt-5 w-25">
        <div class="border-round p-5 bg-light">
            <form @submit.prevent="regUser" method="POST">
                <input type="hidden" v-model="this.POST" />
                <input type="hidden" name="" v-model="this.csrfToken" />

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

                <button type="submit"  class="btn btn-primary w-100 mt-4">Registriraj se</button>
                <div v-if="successReg" class="alert alert-success mt-3" role="alert">
                    {{poruka}} <a href="/login">Prijava</a>
                </div>
            </form>

        </div>

    </div>
</template>

<script>
import axios from "axios";

export default{
    data(){
        return{
            form: {
                email: "",
                password: "",
            },
            errors: {},
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


    }


}
</script>

<style scoped>

</style>
