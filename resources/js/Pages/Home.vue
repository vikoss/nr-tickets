<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: {
        type: Object,
        required: true,
    },
    isAdmin: {
        type: Boolean,
        default: false,
    },
});

const cards = [
    {
        title: 'Nuevo Servicio',
        description: 'Registrar un nuevo servicio de GPS',
        icon: 'M12 4v16m8-8H4',
        href: '/servicios/create',
        color: 'bg-brand-primary-500 hover:bg-brand-primary-600',
    },
    {
        title: 'Servicios',
        description: 'Ver lista de servicios registrados',
        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
        href: '/servicios',
        color: 'bg-brand-secondary-500 hover:bg-brand-secondary-600',
    },
];

const adminCards = [
    {
        title: 'Gestión de Usuarios',
        description: 'Administrar técnicos y usuarios',
        icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        href: '/admin/users',
        color: 'bg-brand-accent-500 hover:bg-brand-accent-600',
    },
    {
        title: 'Sucursales',
        description: 'Administrar sucursales',
        icon: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
        href: '/admin/sucursales',
        color: 'bg-gray-600 hover:bg-gray-700',
    },
];
</script>

<template>
    <Head title="Inicio" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Inicio
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Summary -->
                <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="overflow-hidden rounded-lg bg-white p-6 shadow dark:bg-gray-800">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total de Servicios</div>
                        <div class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ stats.total_servicios }}</div>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white p-6 shadow dark:bg-gray-800">
                        <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Servicios Hoy</div>
                        <div class="mt-1 text-3xl font-bold text-gray-900 dark:text-white">{{ stats.servicios_hoy }}</div>
                    </div>
                </div>

                <!-- Main Action Cards -->
                <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <Link
                        v-for="card in cards"
                        :key="card.title"
                        :href="card.href"
                        class="group relative overflow-hidden rounded-xl p-6 shadow-lg transition-all duration-300 hover:shadow-xl"
                        :class="card.color"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ card.title }}</h3>
                                <p class="mt-1 text-sm text-white/80">{{ card.description }}</p>
                            </div>
                            <svg
                                class="h-12 w-12 text-white/50 transition-transform group-hover:scale-110"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    :d="card.icon"
                                />
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="inline-flex items-center text-sm font-medium text-white">
                                Ir
                                <svg class="ml-1 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </Link>
                </div>

                <!-- Admin Cards (only visible to admins) -->
                <div v-if="isAdmin" class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <h3 class="col-span-full text-lg font-semibold text-gray-700 dark:text-gray-300">Administración</h3>
                    <Link
                        v-for="card in adminCards"
                        :key="card.title"
                        :href="card.href"
                        class="group relative overflow-hidden rounded-xl p-6 shadow-lg transition-all duration-300 hover:shadow-xl"
                        :class="card.color"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ card.title }}</h3>
                                <p class="mt-1 text-sm text-white/80">{{ card.description }}</p>
                            </div>
                            <svg
                                class="h-12 w-12 text-white/50 transition-transform group-hover:scale-110"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    :d="card.icon"
                                />
                            </svg>
                        </div>
                        <div class="mt-4">
                            <span class="inline-flex items-center text-sm font-medium text-white">
                                Ir
                                <svg class="ml-1 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
