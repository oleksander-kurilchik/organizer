<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Register</div>

                    <div class="card-body">
                        <validation-observer ref="form" v-slot="{ handleSubmit }" tag="div" class="">

                            <validation-provider name="name" v-slot="{ errors } " slim>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control " name="name"
                                               v-model="inputs.name" required autocomplete="name" autofocus>
                                        <div class="invalid-feedback d-block">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </div>
                            </validation-provider>
                            <validation-provider name="email" v-slot="{ errors } " slim>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail
                                        Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') "
                                               name="email" v-model="inputs.email" required autocomplete="email">
                                        <div class="invalid-feedback d-block">
                                            {{ errors[0] }}
                                        </div>


                                    </div>
                                </div>
                            </validation-provider>
                            <validation-provider name="password" v-slot="{ errors } " slim>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control " name="password"
                                               v-model="inputs.password" required autocomplete="new-password">
                                        <div class="invalid-feedback d-block">
                                            {{ errors[0] }}
                                        </div>

                                    </div>
                                </div>
                            </validation-provider>
                            <validation-provider name="password_confirmation" v-slot="{ errors } " slim>
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm
                                        Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                               v-model="inputs.password_confirmation" name="password_confirmation"
                                               required autocomplete="new-password">
                                        <div class="invalid-feedback d-block">
                                            {{ errors[0] }}
                                        </div>
                                    </div>
                                </div>
                            </validation-provider>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" @click="onRegister" class="btn btn-primary">
                                        Register
                                    </button>
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
    name: "Registration",
    data() {
        return {
            inputs: {}
        }
    },
    methods: {
        onRegister() {
            let payload = this.inputs;
            this.$http.post(window.routes.auth.registration,payload).then((response) => {
                console.log('login response', response)
                this.$router.push({name:'events.index'})
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
