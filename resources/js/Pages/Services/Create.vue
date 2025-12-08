<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    userData: {
        type: Object,
        required: true,
    },
    tiposServicio: {
        type: Object,
        required: true,
    },
    fechaActual: {
        type: String,
        required: true,
    },
});

const form = useForm({
    tipo_servicio: '',
    numero_serie: '',
    evidencias: [],
});

// For preview
const previews = ref([]);

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('es-MX', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const handleFileChange = (event) => {
    const files = Array.from(event.target.files);
    
    if (files.length !== 2) {
        alert('Por favor seleccione exactamente 2 imágenes.');
        event.target.value = '';
        return;
    }
    
    // Clear previous previews
    previews.value.forEach(url => URL.revokeObjectURL(url));
    previews.value = [];
    
    // Set files in form
    form.evidencias = files;
    
    // Create previews
    files.forEach(file => {
        previews.value.push(URL.createObjectURL(file));
    });
};

const removeImage = (index) => {
    const newFiles = [...form.evidencias];
    newFiles.splice(index, 1);
    form.evidencias = newFiles;
    
    URL.revokeObjectURL(previews.value[index]);
    previews.value.splice(index, 1);
};

const submit = () => {
    // Check if user has sucursal assigned
    if (!props.userData.sucursal) {
        alert('No tienes una sucursal asignada. Contacta al administrador.');
        return;
    }
    
    form.post(route('servicios.store'), {
        forceFormData: true,
        onSuccess: () => {
            form.reset();
            previews.value.forEach(url => URL.revokeObjectURL(url));
            previews.value = [];
        },
    });
};

const canSubmit = computed(() => {
    return form.tipo_servicio && 
           form.numero_serie && 
           form.numero_serie.length >= 5 &&
           form.evidencias.length === 2 &&
           props.userData.sucursal;
});
</script>

<template>
    <Head title="Nuevo Servicio" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Nuevo Servicio
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-800">
                    <form @submit.prevent="submit" class="p-6">
                        <!-- Read-only User Info -->
                        <div class="mb-8 rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Información del Técnico</h3>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <InputLabel value="Nombre" />
                                    <div class="mt-1 rounded-md bg-gray-100 px-3 py-2 text-sm text-gray-700 dark:bg-gray-600 dark:text-gray-200">
                                        {{ userData.name }}
                                    </div>
                                </div>
                                <div>
                                    <InputLabel value="Fecha y Hora" />
                                    <div class="mt-1 rounded-md bg-gray-100 px-3 py-2 text-sm text-gray-700 dark:bg-gray-600 dark:text-gray-200">
                                        {{ formatDate(fechaActual) }}
                                    </div>
                                </div>
                                <div>
                                    <InputLabel value="Número de Empleado" />
                                    <div class="mt-1 rounded-md bg-gray-100 px-3 py-2 text-sm text-gray-700 dark:bg-gray-600 dark:text-gray-200">
                                        {{ userData.numero_empleado || '-' }}
                                    </div>
                                </div>
                                <div>
                                    <InputLabel value="Sucursal" />
                                    <div class="mt-1 rounded-md px-3 py-2 text-sm" :class="userData.sucursal ? 'bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-200' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200'">
                                        {{ userData.sucursal?.nombre || 'Sin sucursal asignada' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Service Type -->
                        <div class="mb-6">
                            <InputLabel for="tipo_servicio" value="Tipo de Servicio" class="required" />
                            <select
                                id="tipo_servicio"
                                v-model="form.tipo_servicio"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-primary-500 focus:ring-brand-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                required
                            >
                                <option value="" disabled>Seleccione un tipo</option>
                                <option v-for="(label, key) in tiposServicio" :key="key" :value="key">
                                    {{ label }}
                                </option>
                            </select>
                            <InputError :message="form.errors.tipo_servicio" class="mt-2" />
                        </div>

                        <!-- Serial Number -->
                        <div class="mb-6">
                            <InputLabel for="numero_serie" value="Número de Serie del GPS" class="required" />
                            <TextInput
                                id="numero_serie"
                                v-model="form.numero_serie"
                                type="text"
                                class="mt-1 block w-full font-mono"
                                placeholder="Ej: GPS-12345-ABC"
                                required
                                minlength="5"
                                maxlength="128"
                            />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Entre 5 y 128 caracteres. Solo letras, números, guiones y guiones bajos.
                            </p>
                            <InputError :message="form.errors.numero_serie" class="mt-2" />
                        </div>

                        <!-- Evidence Images -->
                        <div class="mb-6">
                            <InputLabel value="Evidencias (2 imágenes requeridas)" class="required" />
                            <div class="mt-2">
                                <label
                                    class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-6 transition-colors hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600"
                                >
                                    <svg class="mb-2 h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">
                                        Toque para capturar o seleccionar 2 imágenes
                                    </span>
                                    <input
                                        type="file"
                                        accept="image/*"
                                        capture="environment"
                                        multiple
                                        class="hidden"
                                        @change="handleFileChange"
                                    />
                                </label>
                            </div>
                            
                            <!-- Image Previews -->
                            <div v-if="previews.length > 0" class="mt-4 grid grid-cols-2 gap-4">
                                <div v-for="(preview, index) in previews" :key="index" class="relative">
                                    <img
                                        :src="preview"
                                        :alt="`Evidencia ${index + 1}`"
                                        class="h-40 w-full rounded-lg object-cover"
                                    />
                                    <button
                                        type="button"
                                        @click="removeImage(index)"
                                        class="absolute -right-2 -top-2 rounded-full bg-red-500 p-1 text-white shadow-lg hover:bg-red-600"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <div class="absolute bottom-2 left-2 rounded bg-black/50 px-2 py-1 text-xs text-white">
                                        Evidencia {{ index + 1 }}
                                    </div>
                                </div>
                            </div>
                            
                            <InputError :message="form.errors.evidencias" class="mt-2" />
                            <InputError :message="form.errors['evidencias.0']" class="mt-2" />
                            <InputError :message="form.errors['evidencias.1']" class="mt-2" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <PrimaryButton
                                :disabled="!canSubmit || form.processing"
                                :class="{ 'opacity-50': !canSubmit || form.processing }"
                            >
                                <span v-if="form.processing">Guardando...</span>
                                <span v-else>Registrar Servicio</span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.required::after {
    content: ' *';
    color: #ef4444;
}
</style>
