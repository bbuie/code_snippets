import AuthorizedComponent from './authorized.vue';

export default {
    path: '',
    component: AuthorizedComponent,
    meta: {
        requiresAuth: true,
    },
    children: []
};
