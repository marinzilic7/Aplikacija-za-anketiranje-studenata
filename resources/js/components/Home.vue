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

</template>

<script>
import { mapState } from "vuex";

export default {


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
};
</script>

<style>

.logMessage{
    width:10%;
    position: absolute;
}

</style>
