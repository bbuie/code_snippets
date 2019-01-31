import SubscriberComponent from './subscriber.vue';
import DashboardComponent from './dashboard/dashboard.vue';

export default {
    path: '',
    component: SubscriberComponent,
    meta: {
        requiresSubscription: true,
    },
    children: [
        {
            path: '/',
            name: 'dashboard',
            component: DashboardComponent,
        },
    ]
};
