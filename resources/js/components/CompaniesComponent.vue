<template>
    <h1>Companies</h1>
    <router-link class="btn btn-primary" to="/create-company">Create new company</router-link>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Country</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(company, index) in companies" :key="index">
            <td>{{ company.name }}</td>
            <td>{{ company.email }}</td>
            <td>{{ company.country }}</td>
            <td>
                <router-link class="btn btn-primary me-2"  :to="{ name: 'company-edit', params: { id: company.id } }">
                    Edit
                </router-link>
                <button class="btn btn-danger" @click="deleteCompany(company.id)">Delete</button>
            </td>
        </tr>
        </tbody>
    </table>

    <div v-if="pagesCount >= 2">
        <ul class="pagination justify-content-center">
            <li v-for="page in pagesCount" :key="page" class="page-item" :class="{ 'active': page === currentPage }">
                <a class="page-link" @click="loadCompanies(page)" href="#">{{ page }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data(){
        return {
            companies: [],
            pagesCount: 0,
            currentPage: 1,
        }
    },
    methods: {
        loadCompanies(page) {
            var component = this;
            axios.get(`/companies?page=${page}`)
                .then(function (response) {
                    if (response?.data?.data != undefined) {
                        component.companies = response?.data?.data;
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
        deleteCompany(id) {
            const confirmed = window.confirm("Are you sure you want to delete this item?");

            if (!confirmed) {
                return;
            }
            var component = this;
            axios.delete(`/companies/${id}`)
                .then(function (response) {
                    if (response?.data?.success) {
                        component.loadCompanies(1);
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
        this.loadCompanies(1);
    }
}
</script>

<style scoped>

</style>
