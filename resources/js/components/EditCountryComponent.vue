<template>
    <div class="row justify-content-center mt-2">
        <div class="col-md-6">
            <router-link class="btn btn-primary mt-2" to="/">Back</router-link>
        </div>
    </div>
    <div v-if="error" class="alert alert-danger mt-2" role="alert">
        {{ error }}
    </div>

    <div class="row justify-content-center mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Editing of ountry</div>
                <div class="card-body">
                    <form method="POST" @submit.prevent="editCountry">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" required="required"  class="form-control" id="name" v-model="name">
                        </div>
                        <div class="form-group">
                            <label for="plan">Plan</label>
                            <input type="number" min="1" required="required"  class="form-control" id="plan" v-model="plan"/>
                        </div>
                        <div class="form-group">
                            <label for="unit">Unit</label>
                            <select required="required" class="form-select" v-model="unit" id="unit">
                                <option value=""></option>
                                <option value="t">t</option>
                                <option value="kg">kg</option>
                                <option value="g">g</option>
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
            plan: '',
            unit: '',
            error: ''
        }
    },
    methods: {
        editCountry(){
            var component = this;
            axios.put(
                `/countries/${this.$route.params.id}`,{
                    name: this.name,
                    plan: this.plan,
                    unit: this.unit,
                }
            )
                .then(function (response) {
                    if (response.data.data != undefined) {
                        component.$router.push('/');
                    }
                })
                .catch(function (error) {
                    if (error?.response?.data?.message != undefined) {
                        component.error = error.response.data.message;
                    }
                });
        }
    },
    mounted() {
        var component = this;
        axios.get(`/countries/${this.$route.params.id}`)
            .then(function (response) {
                if (response?.data?.data != undefined) {
                    component.name = response?.data?.data?.name;
                    component.plan = response?.data?.data?.plan;
                    component.unit = response?.data?.data?.unit;
                }
            })
            .catch(function (error) {
                if (error?.response?.data?.message != undefined) {
                    component.error = error.response.data.message;
                }
            });
    }
}
</script>

<style scoped>

</style>

