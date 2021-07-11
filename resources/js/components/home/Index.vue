<template>
    <div class="card">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <router-link :to="{name:'events.index'}" class="card-link">Events</router-link>
            </li>
            <li v-if="showLogin" class="list-group-item">
                <router-link :to="{name:'login'}" class="card-link">Login</router-link>
            </li>
            <li v-if="showLogout" class="list-group-item">
                <a  @click="logout" class="card-link">Logout</a>
            </li>

        </ul>
    </div>

</template>

<script>
export default {
    name: "Index",
    data(){
        return {
            hasToken:null
        };
    },
    created() {
        this.hasToken  =  !!localStorage.getItem('token')
    },
    methods:{
        logout(){
            this.$http.post(window.routes.auth.logout)
                .then((response)=>{
                    localStorage.removeItem('token');
                    this.hasToken = false;
                })
                .catch((error)=>{
                    console.log('logout error', error)
                })
                .finally();
        }
    },
    computed:{
        showLogin(){
            return !this.hasToken;
        },
        showLogout(){
            return this.hasToken;
        },
    }
}
</script>

<style scoped>

</style>
