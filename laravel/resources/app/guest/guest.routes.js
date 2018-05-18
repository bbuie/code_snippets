import GuestComponent from './guest.vue';
import UserRoutes from './user/user.routes';

export default {
    path: 'guest',
    name: 'guest',
    component: GuestComponent,
    children: [
        UserRoutes,
    ]
};
