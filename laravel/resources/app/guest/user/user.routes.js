import UserComponent from './user.vue';
import LoginComponent from './login/login.vue';
import RegisterComponent from './register/register.vue';
import ForgotPasswordComponent from './forgot-password/forgot-password.vue';
import ResetPasswordComponent from './reset-password/reset-password.vue';

export default {
    path: '/user',
    name: 'user',
    redirect: { name: 'home' },
    component: UserComponent,
    children: [
        {
            path: 'login',
            name: 'login',
            component: LoginComponent,
        },
        {
            path: 'register',
            name: 'register',
            component: RegisterComponent,
        },
        {
            path: 'forgot',
            name: 'forgot-password',
            component: ForgotPasswordComponent,
        },
        {
            path: 'reset-password',
            name: 'reset-password',
            component: ResetPasswordComponent,
        }
    ],
};
