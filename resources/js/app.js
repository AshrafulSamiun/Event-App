
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import {createApp} from 'vue';

import { Form } from 'vform';
window.Form=Form;

import Swal from 'sweetalert2';
window.Swal = Swal;

window.showAlert = function (title,text,icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon
    });
};

window.showToast = function (message, icon = 'success') {
    Swal.fire({
        toast: true,
        icon: icon,               // 'success', 'error', 'warning', etc.
        title: message,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    });
};

window.toast = function (icon, title) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    Toast.fire({
        icon: icon,
        title: title
    });
}

import $ from 'jquery';
window.$ = $;

import router from './router';

const app = createApp({});
app.use(router);
app.mount('#app');