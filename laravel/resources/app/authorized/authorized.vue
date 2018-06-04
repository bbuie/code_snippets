<template>
    <loading-spinner :showSpinner="loadingUser">
        <div class="vueAuthorizedView container-fluid">
            <p>You're authorized. Your email is: <span v-if="user">{{ user.email }}</span></p>
            <p>You're authorized for account id: {{ currentAccount.id }}</p>
            <a v-on:click.prevent="logout" href="">Logout</a>
        </div>
    </loading-spinner>
</template>
<script src="./authorized.controller.js"></script>
