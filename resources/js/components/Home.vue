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
                                <div>
                                            <label for="category"
                                                >Predmet:</label
                                            >
                                            <select
                                                id="category"
                                                class="ms-2"
                                                v-model="anketa.category_id"
                                                required
                                            >
                                                <option value="">
                                                    Odaberi predmet
                                                </option>
                                                <option
                                                    v-for="predmet in predmeti"
                                                    :value="predmet.id"
                                                    :key="predmet.id"
                                                >
                                                    {{ predmet.name }}
                                                </option>
                                            </select>
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
                                Zatvori
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ANKETE -->
    <div class="container">
        <div class="d-flex flex-column mt-5 p-5">
            <div
                class="border w-100 p-5 mt-3"
                v-for="anketa in ankete"
                :key="anketa.id"
            >
                <h4>{{ anketa.naziv }}</h4>

                <h4 class="fw-bold text-center mt-3"></h4>
                <form class="px-4" action="">
                    <p class="fw-bold">{{ anketa.opis }}</p>
                    <p class="fw-bold">Predmet: {{ anketa.category.name }}</p>
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
                    <button
                        type="button"
                        class="btn btn-sm btn-warning ms-2"
                        data-bs-toggle="modal"
                        :data-bs-target="'#updateModal' + anketa.id"
                        data-bs-whatever="@getbootstrap"
                        @click="openUpdateAnketa(anketa)"
                    >
                        Uredi
                    </button>

                    <button
                        type="button"
                        class="btn btn-sm btn-danger ms-2"
                        @click="izbrisiAnketu(anketa.id)"
                    >
                        Izbrisi
                    </button>
                </div>
                <div
                    class="modal fade"
                    :id="'updateModal' + anketa.id"
                    tabindex="-1"
                    :aria-labelledby="'exampleModalLabell' + anketa.id"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5
                                    class="modal-title"
                                    :id="'modalUpdate' + anketa.id"
                                >
                                    Uredi anketu
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <div class="modal-body">
                                <form
                                    @submit.prevent="urediAnketu(anketa.id)"
                                    method="POST"
                                >
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
                                            >Naziv:</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="recipient-name"
                                            v-model="form.naziv"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="message-text"
                                            class="col-form-label"
                                            >Opis:</label
                                        >
                                        <textarea
                                            class="form-control"
                                            id="message-text"
                                            v-model="form.opis"
                                        ></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="recipient-name"
                                            class="col-form-label"
                                            >Odgovor 1:</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="recipient-name"
                                            v-model="form.pitanje1"
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
                                            v-model="form.pitanje2"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="recipient-name"
                                            class="col-form-label"
                                            >Odgovor 3:</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="recipient-name"
                                            v-model="form.pitanje3"
                                        />
                                    </div>
                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100"
                                    >
                                        Uredi anketu
                                    </button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary w-100"
                                    data-bs-dismiss="modal"
                                >
                                    Zatvori
                                </button>
                            </div>
                        </div>
                    </div>
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
                category_id:""
            },
            form: {
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
            currentanketaId: null,
            predmeti:[]
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
        this.getPredmeti();
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
                category_id : this.anketa.category_id
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajAnketu", Data)
                .then((response) => {
                    this.poruka = response.data.poruka;
                    this.ankete.push(this.anketa);
                    (this.anketa = {
                        naziv: "",
                        opis: "",
                        pitanje1: "",
                        pitanje2: "",
                        pitanje3: "",
                        category_id:"",
                    }),
                        (this.errors = {});
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
        openUpdateAnketa(anketa) {
            this.currentanketaId = anketa.id; // Postavljamo trenutni ID kursa koji se ažurira
            this.form.naziv = anketa.naziv; // Postavljamo vrijednost forme na trenutni naslov kursa
            this.form.opis = anketa.opis; // Postavljamo vrijednost forme na trenuti opis kursa
            this.form.pitanje1 = anketa.pitanje1; // Postavljamo vrijednost forme na trenuti opis kursa
            this.form.pitanje2 = anketa.pitanje2; // Postavljamo vrijednost forme na trenuti opis kursa
            this.form.pitanje3 = anketa.pitanje3; // Postavljamo vrijednost forme na trenuti opis kursa
            $("#updateModal" + anketa.id).modal("show"); // Prikazujemo modal za ažuriranje kursa
        },
        urediAnketu(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            console.log(id);

            axios
                .post(`/urediAnketu/${id}`, {
                    naziv: this.form.naziv,
                    opis: this.form.opis,
                    pitanje1: this.form.pitanje1,
                    pitanje2: this.form.pitanje2,
                    pitanje3: this.form.pitanje3,
                })
                .then((response) => {
                    const updatedAnketa = response.data.anketa;
                    console.log(updatedAnketa);
                    const index = this.ankete.findIndex(
                        (anketa) => anketa.id === this.currentanketaId
                    );
                    if (index !== -1) {
                        /* this.courses.splice(index, 1, updatedCourse); */
                        this.ankete[index].naziv = updatedAnketa.naziv;
                        this.ankete[index].opis = updatedAnketa.opis;
                        this.ankete[index].pitanje1 = updatedAnketa.pitanje1;
                        this.ankete[index].pitanje2 = updatedAnketa.pitanje2;
                        this.ankete[index].pitanje3 = updatedAnketa.pitanje3;
                    }

                    $("#updateModal" + this.currentanketaId).modal("hide");
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getPredmeti() {
            axios
                .get("/getPredmeti")
                .then((response) => {
                    this.predmeti = response.data;
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
