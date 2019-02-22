import GuestComponent from './guest.vue';
import UserRoutes from './user/user.routes';
import UpgradeRequired from './upgrade-required/upgrade-required';

export default {
    path: 'guest',
    name: 'guest',
    component: GuestComponent,
    children: [
        UserRoutes,
        {
            path: 'upgrade-required',
            name: 'upgrade-required',
            component: UpgradeRequired
        }
    ]
};
