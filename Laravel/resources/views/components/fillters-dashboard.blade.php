<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 rounded-xl mb-6">
    
    <!-- Lado esquerdo (filtros) -->
    <div class="flex flex-col md:flex-row items-start md:items-center gap-3">
        {{ $filters ?? '' }}
    </div>

    <!-- Lado direito (importar CSV) -->
    <div>
        <label class="cursor-pointer bg-[#749048] hover:bg-[#517517] text-white px-4 py-2 rounded-full flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v-8m0 0l-4 4m4-4l4 4" />
            </svg>
            Importar CSV
            <input type="file" name="file" class="hidden" accept=".csv">
        </label>
    </div>

</div>