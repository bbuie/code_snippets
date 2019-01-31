<template lang="html">
    <div class="loadingSpinnerComponent">
        <slot v-if="!showSpinner"></slot>
        <div v-if="showSpinner" :class="customClass + ' loading-spinner'">
            <i class="fa fa-spin fa-circle-o-notch"></i>
        </div>
    </div>
</template>

<script src="./loading-spinner.controller.js"></script>
<style lang="scss" src="./_loading-spinner.scss" scoped></style>
