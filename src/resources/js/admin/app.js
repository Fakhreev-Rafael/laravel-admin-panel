import '../app';

import { createApp } from 'vue';
import Notification from './components/Notification.vue';
import Select from './components/Select.vue';

const app = createApp({
    mounted() {
        const savedActive = localStorage.getItem('asideState');
        const ASIDE = document.querySelector('#aside');

        if(ASIDE) {
            if(savedActive === 'active') {
                ASIDE.classList.add('aside--active');
            } else {
                ASIDE.classList.remove('aside--active');
            }
        }

        document.addEventListener('click', this.handleGlobalClick);
    },
    methods: {
        handleGlobalClick(event) {
            const USER_MENU = document.querySelector('#user-menu');
            const FILTERS = document.querySelector('#filters');
            const TOGGLE_FILTERS = document.querySelector('#toggle-filters');

            if(USER_MENU && !USER_MENU.contains(event.target)) {
                USER_MENU.classList.remove('user-menu--active');
            }

            if(FILTERS && !FILTERS.contains(event.target) && TOGGLE_FILTERS && !TOGGLE_FILTERS.contains(event.target)) {
                FILTERS.classList.remove('filters--active');
            }

            const SELECTS = document.querySelectorAll('.select');

            SELECTS.forEach(function (select) {
                if(!select.contains(event.target)) {
                    select.classList.remove('select--active');
                }
            });
        }
    },
    setup() {

        // function showPassword(event) {
        //     const FIELD = event.target.closest('.field');
        //     const INPUT = FIELD.querySelector('.field__input');
        //     INPUT.setAttribute('type', 'text');
        // }
        // function hidePassword(event) {
        //     const FIELD = event.target.closest('.field');
        //     const INPUT = FIELD.querySelector('.field__input');
        //     INPUT.setAttribute('type', 'password');
        // }
        function passwordTypeToggle(event) {
            const BUTTON = event.target.closest('.button');
            const FIELD = event.target.closest('.field');
            const INPUT = FIELD.querySelector('.field__input');

            const TYPE = INPUT.getAttribute('type');

            if(TYPE === 'password') {
                INPUT.setAttribute('type', 'text');
            } else {
                INPUT.setAttribute('type', 'password');
            }
        }

        function toggleAside(event) {
            const ASIDE = document.querySelector('#aside');
            ASIDE.classList.toggle('aside--active');

            // Сохраняем состояние в localStorage
            const isActive = ASIDE.classList.contains('aside--active');
            localStorage.setItem('asideState', isActive ? 'active' : 'collapsed');
        }

        function toggleFilters(event) {
            const FILTERS = document.querySelector('#filters');
            FILTERS.classList.toggle('filters--active');
        }

        function toggleUserMenu(event) {
            const USER_MENU = document.querySelector('#user-menu');
            USER_MENU.classList.toggle('user-menu--active');
        }

        return {
            toggleAside,
            toggleUserMenu,
            toggleFilters,
            passwordTypeToggle,
        }
    }
});

window.sortHandler = (option) => {
    const url = new URL(window.location.href);

    url.searchParams.set('sort', option.dataset.value);
    url.searchParams.delete('page');

    window.location.href = url.toString();
};

app.component('notification-component', Notification);
app.component('select-component', Select);

app.mount('#application');