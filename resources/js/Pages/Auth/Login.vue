<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
    settings: Object,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const getSetting = (name,settings) => {
    let setting = '';
    for( let i = 0; i < settings.length; i ++ )
    {
        if( settings[i].name == name ){
            setting = settings[i];
            break;
        }
    }
    return setting;
}
const update = (response) => {
    let name = response.name
    let error = response.error
    let value = response.value
    form[name] = value;
    if( error ) form.errors[name] = error;
    else delete form.errors[name];
}

</script>

<template>
    <BreezeGuestLayout :themeColor="settings ? getSetting('theme_color',settings).value : ''">
        <Head :title="settings ? getSetting('login_title',settings).value ? getSetting('login_title',settings).value : 'Log In' : 'Log In'" />
        <h1 class="text-center"> {{settings ? getSetting('login_page_title',settings).value ? getSetting('login_page_title',settings).value : 'Welcome Back' : 'Welcome Back'}} </h1>
        <h2 class="text-center mb-2 text-theme">{{settings ? getSetting('login_page_sub_title',settings).value ? getSetting('login_page_sub_title',settings).value : 'Fill in below form to sign in' : 'Fill in below form to sign in'}}</h2>
        <BreezeValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div class="row">
                <div class="col mt-3">
                        <!--<label for="email"  >
                            {{settings ? getSetting('login_email_label',settings).value ? getSetting('login_email_label',settings).value : 'Email Address' : 'Email Address'}}
                            <small class="text-danger">{{form.errors.email}}</small>
                        </label>-->
                        <TextInput  placeholder="Email Address"  name="email" id="email" type="email" :class="{'border-danger':form.errors.email}"  required v-on:save="update" />
                </div>
            </div>

            <div class="row">
                <div class="col mt-3">
                        <!--<label for="password" >
                            {{settings ? getSetting('register_password_label',settings).value ? getSetting('register_password_label',settings).value : 'Password' : 'Password'}}
                            <small class="text-danger">{{form.errors.password}}</small>
                        </label>-->
                        <TextInput  placeholder="Password"  name="password" id="password" type="password" :class="{'border-danger':form.errors.password}"  required v-on:save="update" />
                </div>
            </div>
            <!--<div>
                <BreezeLabel for="email" :value="settings ? getSetting('login_email_label',settings).value ? getSetting('login_email_label',settings).value : 'Email Address' : 'Email Address'" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" :value="settings ? getSetting('login_password_label',settings).value ? getSetting('login_password_label',settings).value : 'Password' : 'Password'" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
            </div>-->

            <div class="block mt-4">
                <label class="flex items-center">
                    <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm">{{settings ? getSetting('login_remember_label',settings).value ? getSetting('login_remember_label',settings).value : 'Remember me' : 'Remember me'}} </span>
                </label>
                <div class="text-center">
                 <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{settings ? getSetting('login_button_label',settings).value ? getSetting('login_button_label',settings).value : 'Log In' : 'Log In'}}
                </BreezeButton>
                </div>

                <div class="text-center">
                    <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm ">
                        {{settings ? getSetting('login_forgot_label',settings).value ? getSetting('login_forgot_label',settings).value : 'Forgot your password?' : 'Forgot your password?'}}
                    </Link>
                    <Link v-if="canResetPassword" :href="route('register')" class="underline text-sm ml-4">
                        {{settings ? getSetting('login_register_label',settings).value ? getSetting('login_register_label',settings).value : 'New user? Register' : 'New user? Register'}} 
                    </Link>
                </div>
            </div>

            <div class="flex items-center justify-end ">
                <!--<Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm ">
                    {{settings ? getSetting('login_forgot_label',settings).value ? getSetting('login_forgot_label',settings).value : 'Forgot your password?' : 'Forgot your password?'}}
                </Link>-->

               
            </div>

            <!--<div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('register')" class="underline text-sm">
                    {{settings ? getSetting('login_register_label',settings).value ? getSetting('login_register_label',settings).value : 'New user? Register' : 'New user? Register'}} 
                </Link>
                
            </div>-->
        </form>
    </BreezeGuestLayout>
</template>
