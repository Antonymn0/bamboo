<template>
  <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <BreezeApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div v-if="! hideMenuItems" class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <BreezeNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Home
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('profile')" :active="route().current('profile')">
                                    My Profile
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('employees')" :active="route().current('employees')">
                                    People
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('payroll')" :active="route().current('payroll')">
                                    Payroll
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('reports')" :active="route().current('reports')">
                                    Reports
                                </BreezeNavLink>
                                <BreezeNavLink :href="route('onboard')" :active="route().current('onboard')">
                                    Onboard
                                </BreezeNavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <BreezeInput v-if="! hideMenuItems" id="text" type="text" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" placeholder="Search..." />
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="text-capitalize inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.username }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('preferences')" method="get" as="button">
                                            Preferences
                                        </BreezeDropdownLink>
                                        <BreezeDropdownLink :href="route('notifications')" method="get" as="button">
                                            Notifications
                                        </BreezeDropdownLink>
                                        <BreezeDropdownLink :href="route('admin.leave.approvals.page', user.username)" method="get" as="button">
                                            Leave Approvals
                                        </BreezeDropdownLink>
                                        <BreezeDropdownLink :href="route('profile')" method="get" as="button">
                                            Account
                                        </BreezeDropdownLink>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </BreezeResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 text-capitalize">{{ $page.props.auth.user.first_name }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
export default {
    props:{
        hideNavItems:Boolean
    },
    data: function(){
      return{
        user:this.$page.props.auth.user,
        showingNavigationDropdown:ref(false),
        hideMenuItems: this.hideNavItems ? true : false,

      }
    },
    components:{
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeInput,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link
    }
}
</script>

<style>

</style>