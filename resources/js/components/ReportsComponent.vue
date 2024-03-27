<template>
    <h1>Reports</h1>
    <div v-if="error" class="alert alert-danger mt-2" role="alert">
        {{ error }}
    </div>
    <button class="btn btn-primary" v-on:click="generateMinings">Generate sample data</button>
    <div class="d-flex mt-3">
        <select class="w-25 form-control form-select me-3" id="month" v-model="selectedMonth">
            <option value="">Select month</option>
            <option v-for="option in monthOptions" :value="option.value">{{ option.text }}</option>
        </select>
        <button class="btn btn-primary" @click="getLeadersData">Get Leaders Data</button>
    </div>
    <p v-for="(item, index) in leadersData" :key="index" class="mb-0 mt-3 fs-5">
        <b>{{item.country}}</b> {{item.total_weight}}{{item.unit}} ({{item.plan}}{{item.plan_unit}})
    </p>
</template>

<script>
export default {
    data(){
        return {
            error: '',
            selectedMonth: "",
            monthOptions: [
                { value: '1', text: 'January' },
                { value: '2', text: 'February' },
                { value: '3', text: 'March' },
                { value: '4', text: 'April' },
                { value: '5', text: 'May' },
                { value: '6', text: 'June' },
                { value: '7', text: 'July' },
                { value: '8', text: 'August' },
                { value: '9', text: 'September' },
                { value: '10', text: 'October' },
                { value: '11', text: 'November' },
                { value: '12', text: 'December' }
            ],
            leadersData: [],
        }
    },
    methods: {
        generateMinings() {
            var component = this;
            axios.get(`/generate-minings`)
                .catch(function (error) {
                    if (error?.response?.data?.message != undefined) {
                        component.error = error.response.data.message;
                    }
                });
        },
        getLeadersData()
        {
            if (!this.selectedMonth) {
                alert("Select month, please");
                return;
            }

            var component = this;
            axios.get(`/leaders-report/${this.selectedMonth}`)
                .then(function (response) {
                    if (response?.data?.data != undefined) {
                        component.leadersData = response?.data?.data;
                    }
                })
                .catch(function (error) {
                    if (error?.response?.data?.message != undefined) {
                        component.error = error.response.data.message;
                    }
                });
        }
    },
}
</script>


