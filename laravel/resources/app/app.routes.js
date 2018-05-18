import appComponent from './app.vue';
import guestRoutes from './guest/guest.routes';
import authorizedRoutes from './authorized/authorized.routes';

export default {
    path: '/',
    name: 'app',
    component: appComponent,
    children: [
        guestRoutes,
        authorizedRoutes
    ]
};
