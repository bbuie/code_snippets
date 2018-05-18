<template>
    <loading-spinner :showSpinner="loadingUser">
        <div class="vueAuthorizedView container-fluid">
            You're authorized. Your email is: <span v-if="user">{{ user.email }}</span><br/>
            <a v-on:click.prevent="logout" href="">Logout</a>
        </div>
    </loading-spinner>
</template>
<script src="./authorized.controller.js"></script>
