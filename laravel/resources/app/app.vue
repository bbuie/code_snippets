<template>
    <div class="vueIndexView">
        <loading-spinner :showSpinner="settingEnv" :class="{'mt-3 text-center': settingEnv}">
            <router-view></router-view>
        </loading-spinner>
    </div>
</template>
<style lang="scss" src="./_app.scss" scoped></style>
<script src="./app.controller.js"></script>
