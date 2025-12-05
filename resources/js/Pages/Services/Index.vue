<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    servicios: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    tiposServicio: {
        type: Object,
        required: true,
    },
});

// Local filter state
const localFilters = ref({
    fecha_desde: props.filters.fecha_desde || '',
    fecha_hasta: props.filters.fecha_hasta || '',
    sucursal_id: props.filters.sucursal_id || '',
    tipo_servicio: props.filters.tipo_servicio || '',
});

const applyFilters = () => {
    router.get(route('servicios.index'), {
        ...localFilters.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

const clearFilters = () => {
    localFilters.value = {
        fecha_desde: '',
        fecha_hasta: '',
        sucursal_id: '',
        tipo_servicio: '',
    };
    router.get(route('servicios.index'));
};

const formatDate = (dateString) => {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('es-MX', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <Head title="Lista de Servicios" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Lista de Servicios
                </h2>
                <Link :href="route('servicios.create')">
                    <PrimaryButton>Nuevo Servicio</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Filters -->
                <div class="mb-6 overflow-hidden rounded-lg bg-white p-6 shadow dark:bg-gray-800">
                    <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Filtros</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Desde</label>
                            <input
                                v-model="localFilters.fecha_desde"
                                type="date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-primary-500 focus:ring-brand-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Hasta</label>
                            <input
                                v-model="localFilters.fecha_hasta"
                                type="date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-primary-500 focus:ring-brand-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Servicio</label>
                            <select
                                v-model="localFilters.tipo_servicio"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-primary-500 focus:ring-brand-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm"
                            >
                                <option value="">Todos</option>
                                <option v-for="(label, key) in tiposServicio" :key="key" :value="key">
                                    {{ label }}
                                </option>
                            </select>
                        </div>
                        <div class="flex items-end space-x-2">
                            <button
                                @click="applyFilters"
                                class="rounded-md bg-brand-primary-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-primary-600 focus:outline-none focus:ring-2 focus:ring-brand-primary-500 focus:ring-offset-2"
                            >
                                Filtrar
                            </button>
                            <button
                                @click="clearFilters"
                                class="rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500"
                            >
                                Limpiar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Services Table -->
                <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Fecha
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Tipo de Servicio
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        No. Serie
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Técnico
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Sucursal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Evidencias
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                <tr v-for="servicio in servicios.data" :key="servicio.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ servicio.fecha_formatted }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        <span class="inline-flex items-center rounded-full bg-brand-primary-100 px-2.5 py-0.5 text-xs font-medium text-brand-primary-800 dark:bg-brand-primary-900 dark:text-brand-primary-200">
                                            {{ servicio.tipo_servicio_label }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-mono text-gray-900 dark:text-gray-100">
                                        {{ servicio.numero_serie }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ servicio.user?.name || '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        {{ servicio.sucursal?.nombre || '-' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                        <div class="flex -space-x-2">
                                            <img
                                                v-for="evidencia in servicio.evidencias?.slice(0, 2)"
                                                :key="evidencia.id"
                                                :src="evidencia.url"
                                                :alt="`Evidencia ${evidencia.orden + 1}`"
                                                class="h-8 w-8 rounded border-2 border-white object-cover dark:border-gray-800"
                                            />
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <Link
                                            :href="route('servicios.show', servicio.id)"
                                            class="text-brand-primary-600 hover:text-brand-primary-900 dark:text-brand-primary-400 dark:hover:text-brand-primary-300"
                                        >
                                            Ver detalles
                                        </Link>
                                    </td>
                                </tr>
                                <tr v-if="servicios.data.length === 0">
                                    <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No se encontraron servicios.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div v-if="servicios.meta && servicios.meta.last_page > 1" class="border-t border-gray-200 bg-white px-4 py-3 dark:border-gray-700 dark:bg-gray-800 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                Mostrando {{ servicios.meta.from }} a {{ servicios.meta.to }} de {{ servicios.meta.total }} resultados
                            </div>
                            <div class="flex space-x-2">
                                <Link
                                    v-for="link in servicios.meta.links"
                                    :key="link.label"
                                    :href="link.url"
                                    v-html="link.label"
                                    class="rounded-md px-3 py-2 text-sm"
                                    :class="{
                                        'bg-brand-primary-500 text-white': link.active,
                                        'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600': !link.active && link.url,
                                        'cursor-not-allowed bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500': !link.url,
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
