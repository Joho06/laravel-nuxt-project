<template>
  <!-- Fondo oscuro semiopaco -->
  <div class="fixed inset-0 flex items-center justify-center bg-gray-500/30 bg-opacity-30 backdrop-blur-sm transition-opacity">
    <div class="bg-white p-6 rounded-2xl shadow-xl max-w-md w-full relative">
      <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ props.user.name }}</h2>
      <p class="text-gray-600"><strong>Email:</strong> {{ props.user.email }}</p>
      <p class="text-gray-600"><strong>Ubicación:</strong> {{ props.user.latitude }}, {{ props.user.longitude }}</p>

      <div v-if="loading" class="text-gray-500 mt-2">Cargando clima...</div>
      <div v-if="errorMessage" class="text-red-500 mt-2">{{ errorMessage }}</div>

      <div v-if="!loading && !errorMessage && weather.temperature !== null" class="mt-4 space-y-2">
        <p class="text-blue-600 font-semibold"><strong>Temperatura:</strong> {{ weather.temperature }}°C</p>
        <p class="text-gray-700"><strong>Condición:</strong> {{ weather.condition }}</p>
      </div>

      <!-- Botón de cerrar -->
      <button 
        @click="$emit('close')" 
        class="mt-6 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
      >
        Cerrar
      </button>
    </div>
  </div>
</template>


<script setup>
import { ref, watchEffect } from 'vue'

const props = defineProps({ user: Object })
const weather = ref({
  temperature: null,
  condition: "",
  humidity: null,
  wind: null
})
const loading = ref(true)
const errorMessage = ref(null)

watchEffect(async () => {
  if (props.user) {
    loading.value = true
    errorMessage.value = null

    try {
      const { data } = await useFetch(`http://127.0.0.1:8000/api/users/${props.user.id}/weather`)

      if (!data.value) {
        throw new Error("Datos del clima no disponibles")
      }

      weather.value = data.value
    } catch (error) {
      console.error("Error al obtener el clima:", error)
      errorMessage.value = "No se pudo obtener el clima. Intenta nuevamente más tarde."
    } finally {
      loading.value = false
    }
  }
})
</script>
