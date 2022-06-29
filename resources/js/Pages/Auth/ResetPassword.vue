<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import TextInput from '@/Components/TextInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
    settings: Object,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
    errors:{}
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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
    <BreezeGuestLayout>
        <Head :title="settings ? getSetting('reset_password_title',settings).value ? getSetting('reset_password_title',settings).value : 'Register' : 'Register'" />
        <h1 class="text-center"> {{settings ? getSetting('reset_password_page_title',settings).value ? getSetting('reset_password_page_title',settings).value : 'Reset Password' : 'Reset Password'}} </h1>
        <h2 class="text-center mb-2 text-theme">{{settings ? getSetting('reset_password_page_sub_title',settings).value ? getSetting('reset_password_page_sub_title',settings).value : '' : ''}}</h2>

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <!--<div>
                <BreezeLabel for="email" value="Email" />
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
            </div>-->

            <div class="mt-4">
               <!-- <BreezeLabel for="password" value="Password" />
                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />-->
                    <label for="password"  >
                        {{settings ? getSetting('reset_password_password_label',settings).value ? getSetting('reset_password_password_label',settings).value : 'New Password' : 'New Password'}}
                        <small class="text-danger">{{form.errors.password}}</small>
                    </label>
                    <TextInput  placeholder="New Password"  name="password" id="password" type="password" :class="{'border-danger':form.errors.password}"  required v-on:save="update" />
            </div>

            <div class="mt-4">
                <!--<BreezeLabel for="password_confirmation" value="Confirm Password" />
                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />-->
                    <label for="password"  >
                        {{settings ? getSetting('reset_password_password_confirmation_label',settings).value ? getSetting('reset_password_password_confirmation_label',settings).value : 'Confirm New Password' : 'Confirm New Password'}}
                        <small class="text-danger">{{form.errors.password}}</small>
                    </label>
                    <TextInput  placeholder="Confirm New Password"  name="password_confirmation" id="password_confirmation" type="password" :class="{'border-danger':form.errors.password_confirmation}"  required v-on:save="update" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{settings ? getSetting('reset_password_button_label',settings).value ? getSetting('reset_password_button_label',settings).value : 'Reset Password' : 'Reset Password'}}
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
