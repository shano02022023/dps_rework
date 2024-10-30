<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import PasswordInput from "@/Components/PasswordInput.vue";


const props = defineProps({
    User: {
        type: Array,
        required: true,
    },
    auth: { // Define the auth prop
        type: Object,
        required: true,
    }
});

// Extract the current user's name from the auth prop
const currentUserName = props.auth.user.name;

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submitForm = () => {
    // Check if passwords match
    if (form.password !== form.password_confirmation) {
        Swal.fire({
            icon: "error",
            title: "Passwords Do Not Match",
            text: "Please ensure both password fields match.",
            confirmButtonText: "OK",
            confirmButtonColor: "#d33",
        });
        return; // Stop the form submission if passwords don't match
    }
    // Show SweetAlert confirmation dialog
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to register this user!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, register!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: "Registering...",
                text: "Please wait while we register the user.",
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            // Proceed with form submission if confirmed
            form.post(route("user.store"), {
                onSuccess: () => {
                    Swal.fire({
                        icon: "success",
                        title: "User Registered",
                        text: "The user has been successfully registered!",
                        timer: 2000,
                        showConfirmButton: false,
                    });

                    form.reset("password", "password_confirmation");
                },
                onError: () => {
                    Swal.fire({
                        icon: "error",
                        title: "Failed",
                        text: "There was a problem registering the user. Please try again.",
                    });
                },
            });
        }
    });
};


const DeleteUser = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: "Deleting...",
                text: "Please wait while we delete the registered user data.",
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            router.delete(route("user.destroy", id), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire({
                        icon: "success",
                        title: "Deleted!",
                        text: "The user has been deleted.",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                },
                onError: () => {
                    Swal.fire(
                        "Error!",
                        "Failed to delete the registered user.",
                        "error"
                    );
                },
            });
        }
    });
};
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>
        <div class="container p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Registered Admin List</h2>
                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                >
                    Add User
                </button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in User" :key="index">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <div v-if="user.name !== currentUserName">
                                <Link
                                    :href="route('user.edit', user.id)"
                                    class="btn btn-success btn-sm rounded-0"
                                >
                                    Edit
                                </Link>
                                <button
                                    @click="DeleteUser(user.id)"
                                    class="btn btn-danger btn-sm rounded-0"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

           <!-- Modal -->
<div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Register User
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="submitForm">
                    <div class="row mb-3">
                        <label
                            for="inputName"
                            class="col-sm-2 col-form-label"
                            >Name</label
                        >
                        <div class="col-sm-10">
                            <input
                                type="text"
                                class="form-control"
                                id="inputName"
                                placeholder="Preferred Name"
                                v-model="form.name"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label
                            for="inputEmail"
                            class="col-sm-2 col-form-label"
                            >Email</label
                        >
                        <div class="col-sm-10">
                            <input
                                type="email"
                                class="form-control"
                                id="inputEmail"
                                placeholder="Your Email Address"
                                v-model="form.email"
                            />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label
                            for="inputPassword"
                            class="col-sm-2 col-form-label"
                            >Password</label
                        >
                        <di class="col-sm-10">
                            <PasswordInput
                                type="password"
                                class="form-control"
                                id="inputPassword"
                                placeholder="Password"
                                v-model="form.password"
                            />
                        </di>
                    </div>
                    <div class="row mb-3">
                        <label
                            for="inputConfirmPassword"
                            class="col-sm-2 col-form-label"
                            >Confirm Password</label
                        >
                        <div class="col-sm-10">
                            <PasswordInput
                                type="password"
                                class="form-control"
                                id="inputConfirmPassword"
                                placeholder="Confirm Password"
                                v-model="form.password_confirmation"
                            />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>
                <button type="button" class="btn btn-primary" @click="submitForm">
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>

        </div>
    </AuthenticatedLayout>
</template>
