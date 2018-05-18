<template>
    <div class="vueForgotPasswordVue">

        <h3 class="text-primary">Forgot Password?</h3>

        <div class="form-group">
            <input v-model="credentials.email" type="text" name="email" placeholder="Email Address" class="form-control">
        </div>

        <app-message :type="'error'" :messages="apiErrors" @close="apiErrors = []"></app-message>
        <app-message :type="'success'" :messages="successMessages" @close="successMessages = []"></app-message>

        <div class="pull-right">
            <button class="btn btn-primary" title="Password Recovery" v-on:click="requestResetPasswordEmail(credentials)" v-show="!requestingResetPasswordEmail">SUBMIT</button>
            <span v-show="requestingResetPasswordEmail"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></span>
        </div>

        <router-link to="login">Login</router-link>
    </div>
</template>
<script src="./forgot-password.controller.js"></script>
