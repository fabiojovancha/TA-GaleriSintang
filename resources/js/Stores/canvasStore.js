// @/Stores/canvasStore.js
import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useCanvasStore = defineStore('canvas', () => {
    const showCanvas = ref(false);
    const canvasData = ref([]);

    function show(data) {
        const exists = canvasData.value.some(item => item.nama === data.nama);
        if (!exists) {
            canvasData.value.push(data);
            showCanvas.value = true;
        }
    }

    function hide() {
        showCanvas.value = false;
    }

    function clear() {
        canvasData.value = [];
    }

    return { showCanvas, canvasData, show, hide, clear };
});
