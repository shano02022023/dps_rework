<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Chart from "chart.js/auto";
import { onMounted, ref } from "vue";
import axios from "axios";
import { formatMonth } from "@/functions";

const props = defineProps({
    totalApplicants: String,
    acceptedApplicants: String,
    rejectedApplicants: String,
});

const labels = [
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "11",
    "12",
];

const selectedMonth = ref("");
const selectedYear = ref("");
const isLoading = ref(false);

const lineGraphData = ref([]);
const years = ref([]);

const getLineGraphData = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(
            route("dashboard.lineGraph", {
                year: selectedYear.value,
                month: selectedMonth.value,
            })
        );
        lineGraphData.value = response.data;
        isLoading.value = false;
        await renderLineChart();
    } catch (error) {
        console.error(error);
    }
};

const getYears = async () => {
    try {
        const response = await axios.get(route("dashboard.years"));
        years.value = response.data;
        selectedYear.value = years.value[0].year;
        await getLineGraphData();
    } catch (error) {
        console.error(error);
    }
};

let chartInstance = null;

const renderLineChart = () => {
    const ctx = document.getElementById("myChart").getContext("2d");

    // Destroy the existing chart instance if it exists
    if (chartInstance) {
        chartInstance.destroy();
    }

    // Extract month and count data from lineGraphData
    const labels = lineGraphData.value.map((data) =>
        data.month ? formatMonth(data.month) : `Day ${data.day}`
    );
    const dataCounts = lineGraphData.value.map((data) => data.count);

    // Create a new chart instance and store it in chartInstance
    chartInstance = new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Applicants",
                    data: dataCounts,
                    fill: false,
                    borderColor: "rgb(75, 192, 192)",
                    tension: 0.1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
};
onMounted(() => {
    getYears();
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container-fluid p-2">
            <div class="row g-4">
                <div class="col-md-4">
                    <div
                        class="card p-3 shadow-sm border-0 bg-light"
                        style="max-width: 18rem"
                    >
                        <div class="d-flex align-items-center">
                            <div
                                class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px"
                            >
                                <i class="bx bxs-user"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Total Applicants</h6>
                                <h3 class="mb-0" id="totalApplicants">
                                    {{ props.totalApplicants }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div
                        class="card p-3 shadow-sm border-0 bg-light"
                        style="max-width: 18rem"
                    >
                        <div class="d-flex align-items-center">
                            <div
                                class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px"
                            >
                                <i class="bx bxs-user-check"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Accepted Applicants</h6>
                                <h3 class="mb-0" id="acceptedCount">
                                    {{ props.acceptedApplicants }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div
                        class="card p-3 shadow-sm border-0 bg-light"
                        style="max-width: 18rem"
                    >
                        <div class="d-flex align-items-center">
                            <div
                                class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px"
                            >
                                <i class="bx bxs-user-x"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Rejected Applicants</h6>
                                <h3 class="mb-0" id="rejectedCount">
                                    {{ props.rejectedApplicants }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="selectedYear != ''">
            <div class="p-3">
                <select
                    v-model="selectedYear"
                    @change="getLineGraphData"
                    class="form-select mb-2"
                    aria-label="Default select example"
                >
                    <option
                        v-for="year in years"
                        :key="year"
                        :value="year.year"
                    >
                        {{ year.year }}
                    </option>
                </select>
                <select
                    @change="getLineGraphData"
                    v-model="selectedMonth"
                    class="form-select"
                    aria-label="Default select example"
                >
                    <option value="" selected>Select month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>

            <div
                class="d-flex justify-content-center align-items-center flex-column"
            >
                <div v-if="isLoading" class="mb-3">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
        <div
            v-else
            class="d-flex justify-content-center align-items-center flex-column p-4 border rounded bg-light"
        >
            <i class='bx bxs-folder-minus text-secondary mb-2'></i>
            <!-- Bootstrap icon -->
            <p class="text-secondary fw-semibold">No data to show yet</p>
            <p class="text-muted">Please check back later for updates.</p>
        </div>
    </AuthenticatedLayout>
</template>
