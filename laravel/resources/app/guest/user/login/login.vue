<template>
    <div class="vueLoginVue" v-on:keyup.enter="login()">

        <h3 class="text-primary">Log in to your account</h3>

        <div class="form-group">
            <validated-input v-model="credentials.email" :type="'text'" :name="'email'" :placeholder="'Email Address'" :validationErrors="validationErrors"></validated-input>
        </div>

        <div class="form-group">
            <validated-input v-model="credentials.password" :type="'password'" :name="'password'" :placeholder="'Password'" :validationErrors="validationErrors"></validated-input>
        </div>

        <app-message :type="'error'" :messages="apiErrors" @close="apiErrors = []"></app-message>

        <div class="pull-right">
            <button class="btn btn-primary pull-right" title="Login to Tracking First" v-on:click="login()" v-show="!loggingIn">LOGIN</button>
            <span v-if="loggingIn"><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></span>
        </div>

        <label class="text-muted" for="remember_me">
            <input type="checkbox" name="remember_me" v-model="credentials.remember_me"> Remember Me
        </label>

        <br/><router-link to="register">Create Account</router-link>

        |

        <router-link to="forgot">Forgot Password?</router-link>
    </div>
</template>
<script src="./login.controller.js"></script>
