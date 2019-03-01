import AdminComponent from './admin.vue';

export default {
    path: '/admin',
    name: 'admin',
    component: AdminComponent,
    meta: {
        permissions: ['access super-admin']
    }
};