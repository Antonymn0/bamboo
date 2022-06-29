<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
    settings: Object,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
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
        <Head title="Forgot Password" />

        <div class="mb-4 text-sm">
            {{
                settings ? getSetting('password_reset_description',settings).value ? getSetting('password_reset_description',settings).value : 
                'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.' : 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.'
            }}
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <!--<div>
                <BreezeLabel for="email" :value="settings ? getSetting('password_reset_email_label',settings).value ? getSetting('password_reset_email_label',settings).value : 'Email Address' : 'Email Address'"/>
                <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
            </div>-->
            <div class="row">
                <div class="col">
                        <!--<label for="email" >
                            {{settings ? getSetting('login_email_label',settings).value ? getSetting('login_email_label',settings).value : 'Email Address' : 'Email Address'}}
                            <small class="text-danger">{{form.errors.email}}</small>
                        </label>-->
                        <TextInput  placeholder="Email Address"  name="email" id="email" type="email" :class="{'border-danger':form.errors.email}"  required v-on:save="update" />
                </div>
            </div>

            <div class="flex items-center justify-center mt-2">
                <BreezeButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{settings ? getSetting('password_reset_button_label',settings).value ? getSetting('password_reset_button_label',settings).value : 'Email Password Reset Link' : 'Email Password Reset Link'}}
                </BreezeButton>
            </div>

            <div class="flex items-center justify-end mt-2">
                <Link  :href="route('login')" class="underline text-sm">
                   Login
                </Link>
                
            </div>
        </form>
    </BreezeGuestLayout>
</template>
