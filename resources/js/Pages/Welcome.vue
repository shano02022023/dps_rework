<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <Link :href="route('login')" class="admin-login">Admin Login</Link>
    <div class="body">
    <div class="container">
        <div class="icon-container">
            <center><img src="images/shield.jpg" alt="Icon" /></center>
        </div>
        <h2>DPS</h2>
        <p class="top-text">
            This platform is designed to streamline the process of submitting
            and reviewing applications for security and investigative services.
            As an applicant, you can easily submit your credentials and service
            requests through our secure system. Once submitted, each application
            will be carefully reviewed by our dedicated administration team.
            You’ll be promptly notified when your application is accepted or if
            further action is required.
        </p>
        <Link :href="route('application.create')" class="btn-fill-up">Fill up</Link>
    </div>
    </div>
</template>

<style>
/* CSS styles for the page */
.body {
    background: linear-gradient(115deg, #4cda6d 10%, #70e78c 90%);
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    position: relative;
}

/* Admin Login link styling */
.admin-login {
    position: absolute;
    top: 20px;
    right: 20px;
    text-decoration: none;
    background-color: #28a745;
    color: white;
    padding: 15px 15px; /* Increased padding for larger button */
    border-radius: 8px;
    font-weight: 800; /* Made text more bold */
    font-size: 15px; /* Increased font size */
    transition: background-color 0.3s;
}

.admin-login:hover {
    background-color: #1e7d34;
}

/* Container styling */
.container {
    width: 400px;
    padding: 20px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    text-align: center;
}

/* Icon container styling */
.icon-container {
    margin-bottom: 20px;
}

.icon-container img {
    width: 80px;
    height: 80px;
}

/* Heading styling */
h2 {
    text-align: center;
    margin: 0;
    padding: 0;
}

/* Button for Fill-up form */
.btn-fill-up {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn-fill-up:hover {
    background-color: #1e7d34;
}
</style>
