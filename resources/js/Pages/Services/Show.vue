<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    servicio: {
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
</script>

<template>
    <Head :title="`Servicio - ${servicio.data.numero_serie}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link
                    :href="route('servicios.index')"
                    class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Detalle del Servicio
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
                    <div class="p-6">
                        <!-- Service Header -->
                        <div class="mb-6 border-b border-gray-200 pb-6 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                        {{ servicio.data.tipo_servicio_label }}
                                    </h3>
                                    <p class="mt-1 font-mono text-lg text-gray-600 dark:text-gray-300">
                                        No. Serie: {{ servicio.data.numero_serie }}
                                    </p>
                                </div>
                                <span class="inline-flex items-center rounded-full bg-brand-primary-100 px-3 py-1 text-sm font-medium text-brand-primary-800 dark:bg-brand-primary-900 dark:text-brand-primary-200">
                                    {{ servicio.data.tipo_servicio_label }}
                                </span>
                            </div>
                        </div>

                        <!-- Service Details -->
                        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha y Hora</h4>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ formatDate(servicio.data.fecha) }}
                                </p>
                            </div>
                            
                            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Sucursal</h4>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ servicio.data.sucursal?.nombre || '-' }}
                                </p>
                            </div>
                            
                            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Técnico</h4>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ servicio.data.user?.name || '-' }}
                                </p>
                                <p v-if="servicio.data.user?.numero_empleado" class="text-sm text-gray-500 dark:text-gray-400">
                                    No. Empleado: {{ servicio.data.user.numero_empleado }}
                                </p>
                            </div>
                            
                            <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Registrado</h4>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ formatDate(servicio.data.created_at) }}
                                </p>
                            </div>
                        </div>

                        <!-- Evidence Images -->
                        <div>
                            <h4 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                                Evidencias
                            </h4>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div
                                    v-for="(evidencia, index) in servicio.data.evidencias"
                                    :key="evidencia.id"
                                    class="overflow-hidden rounded-lg shadow-md"
                                >
                                    <a
                                        :href="evidencia.url"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="block"
                                    >
                                        <img
                                            :src="evidencia.url"
                                            :alt="`Evidencia ${index + 1}`"
                                            class="h-64 w-full object-cover transition-transform hover:scale-105"
                                        />
                                    </a>
                                    <div class="bg-gray-100 px-4 py-2 dark:bg-gray-700">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Evidencia {{ index + 1 }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ (evidencia.size / 1024).toFixed(1) }} KB
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p v-if="!servicio.data.evidencias?.length" class="text-center text-gray-500 dark:text-gray-400">
                                No hay evidencias disponibles.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-6 flex justify-end">
                    <Link
                        :href="route('servicios.index')"
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
