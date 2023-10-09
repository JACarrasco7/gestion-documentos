<div>
    <!-- Main modal -->
    <div id="modalConditions" data-modal-target="modalConditions" data-modal-backdrop="static" tabindex="-1"
        aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-center p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Condiciones de uso
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        Faltando menos de un mes para que la Unión Europea promulgue nuevas leyes de privacidad del
                        consumidor para sus ciudadanos, empresas de todo el mundo están actualizando sus acuerdos de
                        términos de servicio para cumplir.
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        El Reglamento General de Protección de Datos de la Unión Europea (G.D.P.R.) entra en vigor el 25
                        de mayo y tiene como objetivo garantizar un conjunto común de derechos de datos en la Unión
                        Europea. Requiere que las organizaciones notifiquen a los usuarios lo antes posible sobre
                        violaciones de datos de alto riesgo que podrían afectarlos personalmente.
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex justify-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="modalConditions" type="button" wire:click="acceptConditions"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{ __('Accept') }}
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
