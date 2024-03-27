<template>
    <div class="row justify-content-center mt-2">
        <div class="col-md-6">
            <router-link class="btn btn-primary mt-2" to="/companies">Back</router-link>
        </div>
    </div>

    <div v-if="error" class="alert alert-danger mt-2" role="alert">
        {{ error }}
    </div>

    <div class="row justify-content-center mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{title}}</div>
                <div class="card-body">
                    <form method="POST" @submit.prevent="submitData">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" required="required"  class="form-control" id="name" v-model="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" min="1" required="required"  class="form-control" id="email" v-model="email"/>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select required="required" class="form-select" v-model="country" id="country">
                                <template v-for="(country, index) in countries" :key="index">
                                    <option :value="country.id">{{ country.name }}</option>
                                </template>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            name: '',
            email: '',
            country: '',
            error: '',
            countries: [],
            title: ''
        }
    },
    methods: {
        createCompany(){
            var component = this;
            axios.post('/companies',{name: this.name, email: this.email, country_id: this.country})
                .then(function (response) {
                    if (response.data.data != undefined) {
                        component.$router.push('/companies');
                    }
                })
                .catch(function (error) {
                    if (error?.response?.data?.message != undefined) {
                        component.error = error.response.data.message;
                    }
                });
        },
        editCompany(id){
            var component = this;
            axios.put(`/companies/${id}`,{name: this.name, email: this.email, country_id: this.country})
                .then(function (response) {
                    if (response.data.data != undefined) {
                        component.$router.push('/companies');
                    }
                })
                .catch(function (error) {
                    if (error?.response?.data?.message != undefined) {
                        component.error = error.response.data.message;
                    }
                });
        },
        loadCountries() {
            var component = this;
            axios.get(`/countries/list`)
                .then(function (response) {
                    if (response?.data?.data != undefined) {
                        component.countries = response?.data?.data;
                    }
                })
                .catch(function (error) {
                    if (error?.response?.data?.message != undefined) {
                        component.error = error.response.data.message;
                    }
                    console.log(error);
                });
        },
        loadCompany(id) {
            var component = this;
            axios.get(`/companies/${id}`)
                .then(function (response) {
                    if (response?.data?.data != undefined) {
                        component.name = response?.data?.data?.name;
                        component.email = response?.data?.data?.email;
                        component.country = response?.data?.data?.country_id;
                    }
                })
                .catch(function (error) {
                    if (error?.response?.data?.message != undefined) {
                        component.error = error.response.data.message;
                    }
                });
        },
        submitData() {
            const id = this.$route.params.id;
            if (id) {
                this.editCompany(id)
            } else {
                this.createCompany();
            }
        }
    },
    mounted() {
        this.loadCountries();
        const id = this.$route.params.id;
        if (id) {
            this.loadCompany(id)
        }

        if (id) {
            this.title = 'Edit company';
        } else {
            this.title = 'Creation of new company';
        }
    }
}
</script>

<style scoped>

</style>
