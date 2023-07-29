<template>
    <div class="home">
        <div class="col-12 d-flex justify-content-end">
            <div
                v-if="loginMessage"
                class="alert alert-success mt-3 me-3 logMessage"
            >
                {{ loginMessage }}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex mt-5 p-5">
            <div class="border" v-for="anketa in ankete" :key="anketa.id">
                <h4>{{ anketa.naziv }}</h4>

                <h4 class="fw-bold text-center mt-3"></h4>
                <form class="px-4" action="">
                    <p class="fw-bold">{{ anketa.opis }}</p>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            id="flexCheckDefault"
                        />
                        <label class="form-check-label" for="flexCheckDefault">
                            {{ anketa.pitanje1 }}
                        </label>
                    </div>

                    <!-- Checked checkbox -->
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            id="flexCheckDefault2"
                        />
                        <label class="form-check-label" for="flexCheckDefault2">
                            {{ anketa.pitanje2 }}
                        </label>
                    </div>

                    <!-- Checked checkbox -->
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            id="flexCheckDefault3"
                        />
                        <label class="form-check-label" for="flexCheckDefault3">
                            {{ anketa.pitanje3 }}
                        </label>
                    </div>
                </form>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";

export default {
    data() {
        return {
            ankete: [],
        };
    },
    computed: {
        ...mapState(["loginMessage"]),
    },
    created() {
        if (this.loginMessage) {
            setTimeout(() => {
                this.$store.commit("setLoginMessage", "");
            }, 2000);
        }


    },
    mounted(){
        this.getAnketa()
    },


    methods: {
        getAnketa() {
            axios
                .get("/getAnketa")
                .then((response) => {
                    this.ankete = response.data.map((anketa) => ({
                        ...anketa,
                        created_at: new Date(
                            anketa.created_at
                        ).toLocaleDateString("hr-HR", {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                        }),
                    }));
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style>
.logMessage {
    width: 10%;
    position: absolute;
}
</style>
