<template lang="html">
    <div class="vueAuthorizedView">
        <loading-spinner :showSpinner="loadingUser">
            <router-view></router-view>
        </loading-spinner>
        <upgrade-modal/>
    </div>
</template>

<script src="./authorized.controller.js"></script>
