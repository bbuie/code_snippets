import AuthorizedComponent from './authorized.vue';

export default {
    path: '',
    name: 'home',
    component: AuthorizedComponent,
    meta: {
        requiresAuth: true,
    },
    children: []
};
