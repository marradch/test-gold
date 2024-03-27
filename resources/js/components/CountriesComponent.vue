<template>
    <h1>Countries</h1>
    <router-link class="btn btn-primary" to="/create-country">Create new country</router-link>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Plan</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(country, index) in countries" :key="index">
            <td>{{ country.name }}</td>
            <td>{{ country.plan }}{{ country.unit }}</td>
            <td>
                <router-link class="btn btn-primary me-2"  :to="{ name: 'country-edit', params: { id: country.id } }">
                    Edit
                </router-link>
                <button class="btn btn-danger" @click="deleteCountry(country.id)">Delete</button>
            </td>
        </tr>
        </tbody>
    </table>

    <div v-if="pagesCount >= 2">
        <ul class="pagination justify-content-center">
            <li v-for="page in pagesCount" :key="page" class="page-item" :class="{ 'active': page === currentPage }">
                <a class="page-link" @click="loadCountries(page)" href="#">{{ page }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data(){
        return {
            countries: [],
            pagesCount: 0,
            currentPage: 1,
        }
    },
    methods: {
        loadCountries(page) {
            var component = this;
            axios.get(`/countries?page=${page}`)
                .then(function (response) {
                    if (response?.data?.data != undefined) {
                        component.countries = response?.data?.data;
                        let pagesCount = response?.data?.meta.total / response?.data?.meta.per_page;
                        pagesCount = parseInt(pagesCount);
                        if (response?.data?.meta.total - pagesCount * response?.data?.meta.per_page) {
                            pagesCount++;
                        }
                        component.pagesCount = pagesCount;
                        component.currentPage = response?.data?.meta.current_page;
                    }
                })
                .catch(function (error) {
                    if (error?.response?.data?.message != undefined) {
                        component.error = error.response.data.message;
                    }
                    console.log(error);
                });
        },
        deleteCountry(id) {
            const confirmed = window.confirm("Are you sure you want to delete this item?");

            if (!confirmed) {
                return;
            }
            var component = this;
            axios.delete(`/countries/${id}`)
                .then(function (response) {
                    if (response?.data?.success) {
                        component.loadCountries(1);
                    }
                })
                .catch(function (error) {
                    if (error?.response?.data?.message != undefined) {
                        component.error = error.response.data.message;
                    }
                    console.log(error);
                });
        },
    },
    mounted() {
        this.loadCountries(1);
    }
}
</script>

<style scoped>

</style>
