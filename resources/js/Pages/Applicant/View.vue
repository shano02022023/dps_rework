<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { formatDate, formatTime } from "@/functions";

const props = defineProps({
    applicant: {
        type: Array,
    },
});

const form = useForm({
    interview_date: "",
    interview_time: "",
});

const currentDate = new Date();

const acceptApplicant = () => {
    Swal.fire({
        title: "Are you sure?",
        text: "Are you sure you want to accept this applicant. Continue?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Processing...",
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            });
            form.post(route("applicant.accept", props.applicant.id), {
                preserveScroll: false,
                preserveState: false,
                onSuccess: () => {
                    Swal.fire({
                        title: "Success",
                        text: "Applicant has been accepted",
                        icon: "success",
                    });
                },
            });
        }
    });
};

const rejectApplicant = () => {
    Swal.fire({
        title: "Are you sure?",
        text: "Are you sure you want to reject this applicant. Continue?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Processing...",
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            });
            form.post(route("applicant.reject", props.applicant.id), {
                preserveScroll: false,
                preserveState: false,
                onSuccess: () => {
                    Swal.fire({
                        title: "Success",
                        text: "Applicant has been rejected",
                        icon: "success",
                    });
                },
            });
        }
    });
};
</script>
<template>
    <Head title="Applicant" />
    <AuthenticatedLayout>
        <div class="container-fluid p-2">
            <p class="fw-normal">View applicant details</p>
            <div class="d-flex flex-row gap-2">
                <Link
                    v-if="applicant.application.status === 'PENDING'"
                    :href="route('applicant.pending.index')"
                    data-switcher
                    data-tab="applicants"
                    class="btn btn-secondary"
                    ><i class="bx bx-arrow-back"></i> Back</Link
                >
                <Link
                    v-if="applicant.application.status === 'ACCEPTED'"
                    :href="route('applicant.accepted.index')"
                    data-switcher
                    data-tab="applicants"
                    class="btn btn-secondary"
                    ><i class="bx bx-arrow-back"></i> Back</Link
                >
                <Link
                    v-if="applicant.application.status === 'REJECTED'"
                    :href="route('applicant.rejected.index')"
                    data-switcher
                    data-tab="applicants"
                    class="btn btn-secondary"
                    ><i class="bx bx-arrow-back"></i> Back</Link
                >
                <div v-if="applicant.application.status === 'PENDING'">
                    <button
                        type="button"
                        class="btn btn-primary me-2"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal"
                    >
                        Accept
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="rejectApplicant"
                    >
                        Reject
                    </button>
                </div>
            </div>

            <div
                v-if="applicant.application.status === 'PENDING'"
                class="alert alert-warning mt-3"
                role="alert"
            >
                Pending
            </div>

            <div
                v-if="applicant.application.status === 'ACCEPTED'"
                class="alert alert-success mt-3"
                role="alert"
            >
                Accepted
            </div>

            <div
                v-if="applicant.application.status === 'REJECTED'"
                class="alert alert-danger mt-3"
                role="alert"
            >
                Rejected
            </div>

            <div
                class="mt-3"
                v-if="applicant.application.status === 'ACCEPTED'"
            > Scheduled Interview: {{ formatDate(applicant.application.interview_date) }} at {{ formatTime(applicant.application.interview_time) }} </div>

            <div class="container mt-3">
                <h2 class="text-center mb-4">Review Information</h2>

                <div class="row">
                    <!-- Applicant Information Column -->
                    <div class="col-md-6">
                        <h3 class="section-header">Applicant Information</h3>
                        <div class="border p-2 rounded review-info">
                            <p><strong>Name: </strong></p>
                            <p id="applicantName">
                                {{ applicant.lastname }},
                                {{ applicant.firstname }}
                                {{ applicant.middlename }}
                            </p>
                            <p><strong>Email: </strong></p>
                            <p id="applicantEmail">{{ applicant.email }}</p>
                            <p>
                                <strong
                                    >Age:
                                    <p id="applicantAge"></p
                                ></strong>
                            </p>
                            <p id="applicantAge">{{ applicant.age }}</p>
                            <p><strong>Sex: </strong></p>
                            <p id="applicantSex">{{ applicant.sex }}</p>
                            <p><strong>Birthdate: </strong></p>
                            <p id="applicantBirthdate">
                                {{ formatDate(applicant.birthdate) }}
                            </p>
                            <p><strong>Height: </strong></p>
                            <p id="applicantHeight">{{ applicant.height }}</p>
                            <p><strong>Weight: </strong></p>
                            <p id="applicantWeight">{{ applicant.weight }}</p>
                            <p><strong>Status: </strong></p>
                            <p id="applicantStatus">{{ applicant.status }}</p>
                            <p><strong>Citizenship: </strong></p>
                            <p id="applicantCitizenship">
                                {{ applicant.citizenship }}
                            </p>
                            <p>
                                <strong
                                    >Address:
                                    <p id="applicantAddress"></p
                                ></strong>
                            </p>
                            <p id="applicantAddress">
                                {{ applicant.barangay }},
                                {{ applicant.municipality }},
                                {{ applicant.province }},
                                {{ applicant.country }}
                            </p>
                        </div>
                    </div>

                    <!-- Parents/Guardian Information Column -->
                    <div class="col-md-6" v-if="applicant.parents != null">
                        <h3 class="section-header">
                            Parents/Guardian Information
                        </h3>
                        <div class="border p-2 rounded review-info">
                            <div
                                v-if="
                                    applicant.parents.mother_firstname != null
                                "
                            >
                                <p><strong>Mother's Name: </strong></p>
                                <p id="parentMothername">
                                    {{ applicant.parents.mother_lastname }},
                                    {{ applicant.parents.mother_fistname }}
                                    {{ applicant.parents.mother_middlename }}
                                </p>
                                <p><strong>Mother's Occupation: </strong></p>
                                <p id="parentMotherOccupation">
                                    {{ applicant.parents.mother_occupation }}
                                </p>
                            </div>
                            <div
                                v-if="
                                    applicant.parents.father_firstname != null
                                "
                            >
                                <p><strong>Father's Name: </strong></p>
                                <p id="parentFathername">
                                    {{ applicant.parents.father_lastname }},
                                    {{ applicant.parents.father_fistname }}
                                    {{ applicant.parents.father_middlename }}
                                </p>

                                <p><strong>Father's Occupation: </strong></p>
                                <p id="parentFatherOccupation">
                                    {{ applicant.parents.father_occupation }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            Set a interview date
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form @submit.prevent="acceptApplicant()">
                        <div class="d-flex flex-row">
                            <div class="modal-body">
                                <div class="container">
                                    <p>Select a Date</p>
                                    <div
                                        class="form-group date-picker-container"
                                    >
                                        <input
                                            v-model="form.interview_date"
                                            :min="currentDate"
                                            type="date"
                                            class="form-control date-picker"
                                            id="dateInput"
                                            placeholder="Select date"
                                            required
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="container mt-3">
                                <p>Select a Time</p>
                                <div class="form-group time-picker-container">
                                    <input
                                        v-model="form.interview_time"
                                        type="time"
                                        class="form-control time-picker"
                                        id="timeInput"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Accept
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
