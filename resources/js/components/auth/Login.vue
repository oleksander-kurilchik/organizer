<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Login' </div>

                    <div class="card-body">
                        <validation-observer ref="form" v-slot="{ handleSubmit }" tag="div" class="">

                            <validation-provider name="email" v-slot="{ errors } " slim>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right"> E-Mail Address </label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control "  v-model="inputs.email" name="email"   required autocomplete="email" autofocus>
                                    <div class="invalid-feedback d-block">
                                        {{ errors[0] }}
                                    </div>
                                </div>
                            </div>
                            </validation-provider>
                            <validation-provider name="password" v-slot="{ errors } " slim>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right"> Password </label>

                                <div class="col-md-6">
                                    <input id="password"   v-model="inputs.password"  type="password" class="form-control " name="password" required autocomplete="current-password">
                                    <div class="invalid-feedback d-block">
                                        {{ errors[0] }}
                                    </div>
                                </div>
                            </div>
                            </validation-provider>



                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4 d-flex align-items-center">
                                    <button type="button" @click="onLogin" class="btn btn-primary">
                                        Login
                                    </button>

                                    <router-link class="ml-3" :to="{name:'registration'}">Registration </router-link>


                                </div>
                            </div>
                        </validation-observer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data(){
        return {
            inputs:{},
        }
    },
    methods:{
        onLogin(){
            let payload = this.inputs;
            this.$http.post(window.routes.auth.login,payload).then((response) => {
                console.log('login response', response)
                localStorage.setItem('token', response.data.token);
                window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
                this.$router.push({name:'index'})
            }).catch(this.handleErrors).finally();
        },
        handleErrors: function (error) {
            console.log('handleErrors ',error, error.response)
            var response = error.response;
            var responseData = response.data;
            if (response.status == 422) {
                var errors = responseData.errors;
                this.$refs.form.setErrors(errors);
            } else {
                this.unknownError = true;
                console.log(error);
            }
        }
    }
}
</script>

<style scoped>

</style>
