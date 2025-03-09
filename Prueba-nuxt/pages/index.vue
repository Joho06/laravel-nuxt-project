<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Lista de Usuarios</h1>
    
    <div v-if="loading" class="text-gray-500 text-center text-lg">Cargando usuarios...</div>
    <div v-if="errorMessage" class="text-red-500 text-center">{{ errorMessage }}</div>
    
    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="user in users"
        :key="user.id"
        @click="showWeather(user)"
        class="p-5 bg-gray-300 border border-gray-900 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer"
      >
        <h2 class="text-lg font-semibold text-gray-900">{{ user.name }}</h2>
        <p class="text-gray-600"><strong>Email:</strong> {{ user.email }}</p>
        <p class="text-gray-600"><strong>Ubicación:</strong> {{ user.latitude }}, {{ user.longitude }}</p>
        <p class="text-gray-800 font-semibold"><strong>Temperatura:</strong> {{ user.weather?.temperature }}°C</p>
        <p class="text-gray-700"><strong>Condición:</strong> {{ user.weather?.condition }}</p>
      </div>
    </div>

    <UserWeatherModal v-if="selectedUser" :user="selectedUser" @close="selectedUser = null" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import UserWeatherModal from '@/components/Modal.vue'

const users = ref([])
const selectedUser = ref(null)
const loading = ref(true)
const errorMessage = ref(null)

const fetchUsers = async () => {
  loading.value = true;
  try {
    const response = await fetch('http://127.0.0.1:8000/api/users');
    const result = await response.json();
    users.value = result;
  } catch (error) {
    errorMessage.value = "No se pudo obtener la lista de usuarios.";
    console.error("Error al obtener usuarios:", error);
  } finally {
    loading.value = false;
  }
};

const showWeather = (user) => {
  selectedUser.value = user
}

onMounted(fetchUsers)
</script>