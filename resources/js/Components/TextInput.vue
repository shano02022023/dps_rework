<script setup>
import { onMounted, ref } from "vue";

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="input-group flex-nowrap">
        <span class="input-group-text" id="addon-wrapping">@</span>
        <input
            v-model="model"
            ref="input"
            type="text"
            class="form-control"
            placeholder="---"
            aria-label="Username"
            aria-describedby="addon-wrapping"
        />
    </div>
</template>
