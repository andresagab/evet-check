<div class="py-12 md:py-24 bg-white dark:bg-gray-800/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Historial de Eventos</h2>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Un vistazo a nuestros eventos más recientes y su impacto.</p>
        </div>

        @if($events->isNotEmpty())
            <!-- Carousel Container -->
            <div x-data="{
                    active: 0,
                    eventsCount: {{ $events->count() }},
                    visibleSlides: 3,
                    maxSteps: 0,
                    updateCarousel() {
                        if (window.innerWidth < 768) {
                            this.visibleSlides = 1;
                        } else if (window.innerWidth < 1024) {
                            this.visibleSlides = 2;
                        } else {
                            this.visibleSlides = 3;
                        }
                        this.maxSteps = Math.max(0, this.eventsCount - this.visibleSlides);
                        if (this.active > this.maxSteps) {
                            this.active = this.maxSteps;
                        }
                    },
                    next() {
                        this.active = Math.min(this.active + 1, this.maxSteps);
                    },
                    prev() {
                        this.active = Math.max(this.active - 1, 0);
                    }
                }"
                 x-init="updateCarousel(); window.addEventListener('resize', () => updateCarousel())"
                 class="mt-12 relative">

                <!-- Carousel Viewport -->
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out"
                         :style="{ transform: `translateX(-${active * (100 / visibleSlides)}%)` }">

                        @foreach ($events as $event)

                            @php
                                $state = $event->get_state();
                            @endphp

                            <div class="flex-shrink-0 px-4" :style="{ width: `${100 / visibleSlides}%` }">
                                <!-- Event Card -->
                                <div class="text-center p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl flex flex-col items-center justify-center h-full border border-transparent hover:border-green-500 transition-colors duration-300">
                                    <div x-data="{ count: 0 }"
                                         x-intersect:enter.once="
                                            let target = {{ $event->event_attendances_count }};
                                            let duration = 2000;
                                            let startTime = null;
                                            function animate(currentTime) {
                                                if (!startTime) startTime = currentTime;
                                                const progress = Math.min((currentTime - startTime) / duration, 1);
                                                count = Math.floor(progress * target);
                                                if (progress < 1) requestAnimationFrame(animate);
                                            }
                                            requestAnimationFrame(animate);
                                         ">
                                        <span x-text="count.toLocaleString('es-CO')" class="text-6xl font-extrabold text-green-600 dark:text-green-400">0</span>
                                        <p class="text-lg font-medium text-gray-600 dark:text-gray-300">Asistentes</p>
                                    </div>
                                    <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">{{ $event->name }}</h3>
                                    <p class="mt-1 text-sm text-{{ $state['color'] }}-500 dark:text-{{ $state['color'] }}-400">{{ __($state['key_name']) }} &middot; {{ $event->year }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Controls -->
                <div x-show="eventsCount > visibleSlides" class="absolute inset-0 flex items-center justify-between pointer-events-none">
                    <button @click="prev()" :disabled="active === 0"
                            class="pointer-events-auto p-2 rounded-full bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm hover:bg-white dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed transition-all -ml-4 lg:-ml-6 shadow-md">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click="next()" :disabled="active >= maxSteps"
                            class="pointer-events-auto p-2 rounded-full bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm hover:bg-white dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed transition-all -mr-4 lg:-mr-6 shadow-md">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="mt-12">
                <p class="text-center text-gray-500 dark:text-gray-400">No hay eventos pasados para mostrar.</p>
            </div>
        @endif
    </div>
</div>
