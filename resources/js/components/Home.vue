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
    <!-- BUTTON ZA DODAVANJE ANKETE  -->
    <div class="container" v-if="isLoggedIn">
        <div class="row d-flex justify-content-center mt-5">
            <button
                type="button"
                class="btn btn-dark ps-3 col-3"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
                data-bs-whatever="@mdo"
            >
                Dodaj anketu
            </button>
            <div
                class="modal fade"
                id="exampleModal"
                tabindex="-1"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                Nova anketa
                            </h1>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="dodajAnketu" method="POST">
                                <input type="hidden" v-model="this.POST" />
                                <input
                                    type="hidden"
                                    name=""
                                    v-model="this.csrfToken"
                                />
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >Naziv ankete :</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="recipient-name"
                                        v-model="anketa.naziv"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label
                                        for="message-text"
                                        class="col-form-label"
                                        >Opis ankete:</label
                                    >
                                    <textarea
                                        class="form-control"
                                        id="message-text"
                                        v-model="anketa.opis"
                                    ></textarea>
                                </div>
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >Odgovor 1 :</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="recipient-name"
                                        v-model="anketa.pitanje1"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >Odgovor 2:</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="recipient-name"
                                        v-model="anketa.pitanje2"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >Odgovor 3 :</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="recipient-name"
                                        v-model="anketa.pitanje3"
                                    />
                                </div>
                                <button
                                    type="submit"
                                    class="btn btn-primary w-100"
                                >
                                    Dodaj anketu
                                </button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary w-100"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ANKETE -->
    <div class="container">
        <div class="d-flex mt-5 p-5">
            <div
                class="border w-100 p-5"
                v-for="anketa in ankete"
                :key="anketa.id"
            >
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
                    <button type="button" class="btn btn-sm btn-primary">
                        Submit
                    </button>
                    <button type="button" class="btn btn-sm btn-warning">
                        Update
                    </button>
                    <button type="button" class="btn btn-sm btn-danger"  @click="izbrisiAnketu(anketa.id)">
                        Izbrisi
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            ankete: [],
            anketa: {
                naziv: "",
                opis: "",
                pitanje1: "",
                pitanje2: "",
                pitanje3: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            poruka: "",
        };
    },
    computed: {
        ...mapState(["loginMessage"]),
        ...mapGetters(["loggedInUser"]),
        isLoggedIn() {
            return this.loggedInUser !== null;
        },
    },
    created() {
        if (this.loginMessage) {
            setTimeout(() => {
                this.$store.commit("setLoginMessage", "");
            }, 2000);
        }
    },
    mounted() {
        this.getAnketa();
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
        dodajAnketu() {
            const Data = {
                naziv: this.anketa.naziv,
                opis: this.anketa.opis,
                pitanje1: this.anketa.pitanje1,
                pitanje2: this.anketa.pitanje2,
                pitanje3: this.anketa.pitanje3,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajAnketu", Data)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.ankete.push(this.anketa);
                    this.anketa = {
                        naziv: "",
                        opis: "",
                        pitanje1: "",
                        pitanje2: "",
                        pitanje3: "",
                    };
                    this.errors = {};
                    this.getAnketa();
                    $(document).ready(function () {

                        $("#exampleModal").modal("hide");



                    });
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
        izbrisiAnketu(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post(`/delete/${id} `)
                .then((response) => {
                    this.ankete = this.ankete.filter(
                        (anketaa) => anketaa.id !== id
                    );

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
