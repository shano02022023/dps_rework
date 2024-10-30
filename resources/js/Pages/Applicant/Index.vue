<script setup>
import Pagination from "@/Components/Pagination.vue";
import { formatDate, formatTime } from "@/functions";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, usePage, Link } from "@inertiajs/vue3";
import { defineProps, ref } from "vue";

const props = defineProps({
    applicants: {
        type: Array,
    },
});

const searchText = ref("");

const searchApplicants = () => {
    router.visit(route(usePage().props.routeName), {
        method: "get",
        data: {
            search: searchText.value,
        },
        preserveState: true,
        preserveScroll: true,
    });
};
</script>
<template>
    <Head title="Applicants" />

    <AuthenticatedLayout>
        <div class="container-fluid p-2">
            <div class="mb-5">Applicants</div>
            <div class="d-flex justify-content-end">
                <div class="input-group flex-nowrap" style="width: 300px">
                    <input
                        @keyup="searchApplicants"
                        v-model="searchText"
                        ref="input"
                        :type="'text'"
                        class="form-control"
                        placeholder="Search"
                        aria-label="Search"
                        aria-describedby="addon-wrapping"
                    />
                    <button
                        type="button"
                        class="input-group-text"
                        id="addon-wrapping"
                    >
                        <i class="bx bx-search-alt-2"></i>
                    </button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th
                            v-if="
                                $page.props.routeName.includes(
                                    'applicant.accepted'
                                )
                            "
                            scope="col"
                        >
                            Interview
                        </th>

                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <div v-if="applicants.data == []">
                        No applicants found in this page
                    </div>
                    <tr v-for="(applicant, index) in applicants.data">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>
                            {{ applicant.applicant.lastname }},
                            {{ applicant.applicant.firstname }}
                            {{ applicant.applicant.middlename }}
                        </td>
                        <td>{{ applicant.applicant.email }}</td>
                        <td
                            v-if="
                                $page.props.routeName.includes(
                                    'applicant.accepted'
                                )
                            "
                        >
                            {{ formatDate(applicant.interview_date) }} at {{ formatTime(applicant.interview_time) }} 
                        </td>
                        <td>
                            <Link
                                :href="
                                    route(
                                        'applicant.view',
                                        applicant.applicant.id
                                    )
                                "
                                class="btn btn-primary"
                            >
                                View
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <Pagination :paginate="applicants" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
