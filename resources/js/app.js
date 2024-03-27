/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import CountriesComponent from "./components/CountriesComponent.vue";
import CreateCountryComponent from "./components/CreateCountryComponent.vue";
import EditCountryComponent from "./components/EditCountryComponent.vue";
import CompaniesComponent from "./components/CompaniesComponent.vue";
import CompanyComponent from "./components/CompanyComponent.vue";
import MenuComponent from "./components/MenuComponent.vue";
import ReportsComponent from "./components/ReportsComponent.vue";

const routes = [
    {
        path: '/',
        component: CountriesComponent,
    },
    {
        path: '/country-edit/:id',
        name: 'country-edit',
        component: EditCountryComponent,
    },
    {
        path: '/create-country',
        component: CreateCountryComponent,
    },
    {
        path: '/companies',
        component: CompaniesComponent,
    },
    {
        path: '/company-edit/:id',
        name: 'company-edit',
        component: CompanyComponent,
    },
    {
        path: '/create-company',
        component: CompanyComponent,
    },
    {
        path: '/reports',
        component: ReportsComponent,
    }
];

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
const router = createRouter({routes, history: createWebHistory()});
const app = createApp({});
app.use(router);
app.component('menu-component', MenuComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
