
import Dashboard from './components/dashboard.vue';

import ListAppointments from './pages/appointments/ListAppointments.vue';

import ListUsers from './pages/users/ListUsers.vue';

import UpdateSetting from './pages/setting/UpdateSetting.vue';

import UpdateProfile from './pages/profile/UpdateProfile.vue';



export  default [
    {

        path: '/admin/dashboard',

        name: 'admin.dashboard',

        component: Dashboard,
    },

    {

        path: '/admin/appointemnts',

        name: 'admin.appointment',

        component: ListAppointments,
    },

    {

        path: '/admin/users',

        name: 'admin.users',

        component: ListUsers,
    },

    {

        path: '/admin/settings',

        name: 'admin.settings',

        component: UpdateSetting,
    },

    {

        path: '/admin/profile',

        name: 'admin.profile',

        component: UpdateProfile,
    },
]