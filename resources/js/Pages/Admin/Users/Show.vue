<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('es-MX', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const getRoleBadgeClass = (role) => {
    if (role === 'admin') {
        return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
    }
    return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
};
</script>

<template>
    <Head :title="`Usuario - ${user.data.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link
                    :href="route('admin.users.index')"
                    class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Detalle del Usuario
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
                    <div class="p-6">
                        <!-- User Header -->
                        <div class="mb-6 flex items-center">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-primary-100 text-2xl font-bold text-brand-primary-600 dark:bg-brand-primary-900 dark:text-brand-primary-300">
                                {{ user.data.name.charAt(0).toUpperCase() }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ user.data.name }}
                                </h3>
                                <p class="text-gray-500 dark:text-gray-400">
                                    {{ user.data.email }}
                                </p>
                            </div>
                        </div>

                        <!-- User Details -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Número de Empleado</h4>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ user.data.numero_empleado || 'No asignado' }}
                                </p>
                            </div>
                            
                            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Sucursal</h4>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ user.data.sucursal?.nombre || 'Sin asignar' }}
                                </p>
                            </div>
                            
                            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Roles</h4>
                                <div class="mt-1">
                                    <span
                                        v-for="role in user.data.roles"
                                        :key="role"
                                        class="mr-2 inline-flex items-center rounded-full px-3 py-1 text-sm font-medium"
                                        :class="getRoleBadgeClass(role)"
                                    >
                                        {{ role.charAt(0).toUpperCase() + role.slice(1) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Registro</h4>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ formatDate(user.data.created_at) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-6 flex justify-end">
                    <Link
                        :href="route('admin.users.index')"
                        class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                    >
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver a la lista
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
