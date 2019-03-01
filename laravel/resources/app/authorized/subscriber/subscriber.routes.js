import SubscriberComponent from './subscriber.vue';
import DashboardComponent from './dashboard/dashboard.vue';
import AdminRoutes from './admin/admin.routes';

export default {
    path: '',
    component: SubscriberComponent,
    meta: {
        requiresSubscription: true,
    },
    children: [
        AdminRoutes,
        {
            path: '/',
            name: 'dashboard',
            component: DashboardComponent,
        },
    ]
};
