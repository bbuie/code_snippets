<template>
    <b-container class="dashboard-container">
        <app-message
            class="mt-3"
            v-if="errorMessages"
            type="error"
            :messages="errorMessages"
            @close="errorMessages = []">
        </app-message>
        <div class="vueAuthorizedView container-fluid">
            This is the dashboard
        </div>
    </b-container>
</template>
<script src="./dashboard.controller.js"></script>
<style lang="scss" src="./_dashboard.scss" scoped></style>
