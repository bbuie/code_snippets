<template>
    <div class="vueResetPasswordVue">

        <h3 class="text-primary">Reset Password</h3>

        <div class="form-group">
            <validated-input v-model="credentials.email" :type="'email'" :name="'email'" :placeholder="'Email'" :validationErrors="validationErrors"></validated-input>
        </div>

        <div class="form-group">
            <validated-input v-model="credentials.password" :type="'password'" :name="'password'" :placeholder="'Enter New Password'" :validationErrors="validationErrors"></validated-input>
        </div>

        <div class="form-group">
            <input v-model="credentials.password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password">
        </div>

        <app-message :type="'error'" :messages="apiErrors" @close="apiErrors = []"></app-message>
        <app-message :type="'success'" :messages="successMessages" @close="successMessages = []">
            <div>Please proceed to <router-link :to="{ name: 'login' }">Login</router-link></div>
        </app-message>

        <div class="pull-right">
            <button class="btn btn-primary pull-right" title="Password Recovery" v-on:click="requestPasswordReset(credentials)" v-show="!requestingPasswordReset">SUBMIT</button>
            <span v-show="requestingPasswordReset"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></span>
        </div>

        <router-link to="login">Login</router-link>
    </div>
</template>

<script src="./reset-password.controller.js"></script>
