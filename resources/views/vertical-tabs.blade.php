<div
    x-data="{
    activeTab: @js($getChildComponentContainer()->getComponents()[0]->getId()),
    isMobileNavOpen: false,
    tabs: [],
    tabsMeta: [],
    currentIndex: 0,

    init() {
        // Initialize tab IDs
        this.tabs = @js(collect($getChildComponentContainer()->getComponents())->pluck('id')->toArray());

        // Fallback if no tabs found
        if (!this.tabs.length) {
            console.warn('No tabs found.');
            return;
        }

        // Set the initial current index
        this.currentIndex = this.tabs.indexOf(this.activeTab);

        // Watch for changes to activeTab and update index
        this.$watch('activeTab', (tabId) => {
            this.currentIndex = this.tabs.indexOf(tabId);
        });

        // Handle window resize for mobile nav behavior
        window.addEventListener('resize', () => {
            this.isMobileNavOpen = window.innerWidth < 1024 ? this.isMobileNavOpen : false;
        });

        // Handle ESC key to close mobile nav
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isMobileNavOpen) {
                this.isMobileNavOpen = false;
            }
        });

        // Collect tab metadata from DOM
        const tabElements = Array.from(this.$el.querySelectorAll('[data-tab-id]'));

        this.tabsMeta = tabElements.map(el => ({
            id: el.dataset.tabId,
            label: el.dataset.tabLabel ?? '',
            iconHtml: el.querySelector('[data-tab-icon]')?.innerHTML ?? '',
        }));
    },

    goToNextTab() {
        if (this.hasNextTab()) {
            this.activeTab = this.tabs[this.currentIndex + 1];
        }
    },

    goToPrevTab() {
        if (this.hasPrevTab()) {
            this.activeTab = this.tabs[this.currentIndex - 1];
        }
    },

    hasPrevTab() {
        return this.currentIndex > 0;
    },

    hasNextTab() {
        return this.currentIndex < this.tabs.length - 1;
    }
}"

        x-init="init()"
        class="filament-vertical-tabs relative"
>
    <!-- Mobile Hamburger Menu Button (visible on small screens) -->
    <div class="sticky top-0 z-20 lg:hidden mb-6 flex justify-between items-center bg-white dark:bg-gray-800 rounded-xl shadow-sm p-3">
        <div class="flex items-center gap-2 font-medium">
            <template x-for="tab in tabsMeta" :key="tab.id">
                <div x-show="tab.id === activeTab" class="flex items-center gap-2" style="display: none;">
                    <div x-html="tab.iconHtml" class="text-primary-500"></div>
                    <span x-text="tab.label" class="text-gray-900 dark:text-white"></span>
                </div>
            </template>
        </div>

        <button
                type="button"
                x-on:click="isMobileNavOpen = !isMobileNavOpen"
                class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500"
                aria-label="Toggle navigation menu"
        >
            <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    x-show="!isMobileNavOpen"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    x-show="isMobileNavOpen"
                    style="display: none;"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile Side Navigation Panel -->
    <div
            x-show="isMobileNavOpen"
            x-on:click.away="isMobileNavOpen = false"
            class="fixed inset-0 z-30 lg:hidden"
            style="display: none;"
    >
        <!-- Backdrop overlay -->
        <div
                class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-on:click="isMobileNavOpen = false"
        ></div>

        <!-- Side panel -->
        <div
                class="absolute top-0 left-0 h-full w-3/4 max-w-xs bg-white dark:bg-gray-800 shadow-xl overflow-y-auto"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform -translate-x-full"
        >
            <div class="sticky top-0 bg-white dark:bg-gray-800 z-10 p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="font-medium text-gray-900 dark:text-gray-100 text-lg">
                    {{ $getLabel() ?? 'Navigation' }}
                </h3>
                <button
                        type="button"
                        x-on:click="isMobileNavOpen = false"
                        class="p-1 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="p-4">
                @foreach ($getChildComponentContainer()->getComponents() as $tab)
                    <button
                            type="button"
                            x-on:click="if (activeTab !== '{{ $tab->getId() }}') activeTab = '{{ $tab->getId() }}'; isMobileNavOpen = false"
                            class="w-full text-left px-4 py-3 my-1 flex items-center gap-3 text-sm transition rounded-lg"
                            :class="{
                            'bg-primary-50 dark:bg-primary-500/20 text-primary-600 dark:text-primary-400 font-medium': activeTab === '{{ $tab->getId() }}',
                            'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700': activeTab !== '{{ $tab->getId() }}'
                        }"
                    >
                        @if($tab->getIcon())
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg"
                                  :class="{
                                    'bg-primary-100 dark:bg-primary-800/30 text-primary-600 dark:text-primary-400': activeTab === '{{ $tab->getId() }}',
                                    'text-gray-500 dark:text-gray-400': activeTab !== '{{ $tab->getId() }}'
                                }">
                                <x-dynamic-component :component="$tab->getIcon()" class="h-5 w-5" />
                            </span>
                        @endif
                        {{ $tab->getLabel() }}
                    </button>
                @endforeach
            </nav>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Vertical Navigation (hidden on mobile) -->
        <div class="hidden lg:block w-64 shrink-0">
            <div class="pr-4 rtl:pr-0 rtl:pl-4 sticky top-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    @if ($getLabel() !== '')
                        <h3 class="font-medium text-gray-900 dark:text-gray-100 p-4 border-b border-gray-200 dark:border-gray-700 text-sm">
                            {{ $getLabel() }}
                        </h3>
                    @endif
                    <nav class="flex flex-col py-2">
                        @foreach ($getChildComponentContainer()->getComponents() as $tab)
                            <button
                                    type="button"
                                    x-on:click="if (activeTab !== '{{ $tab->getId() }}') activeTab = '{{ $tab->getId() }}'"
                                    class="flex items-center gap-3 px-4 py-3 mx-2 my-0.5 rounded-lg text-sm transition relative"
                                    data-tab-id="{{ $tab->getId() }}"
                                    data-tab-label="{{ $tab->getLabel() }}"
                                    :class="{
                                    'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-500/20 font-medium': activeTab === '{{ $tab->getId() }}',
                                    'text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-50 dark:hover:bg-gray-800/50': activeTab !== '{{ $tab->getId() }}'
                                }"
                            >
                                @if($tab->getIcon())
                                    <span
                                            data-tab-icon
                                            class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors"
                                            :class="{
                                            'bg-primary-100 dark:bg-primary-800/30 text-primary-600 dark:text-primary-400': activeTab === '{{ $tab->getId() }}',
                                            'text-gray-500 dark:text-gray-400': activeTab !== '{{ $tab->getId() }}'
                                        }"
                                    >
                                        <x-dynamic-component :component="$tab->getIcon()" class="h-5 w-5" />
                                    </span>
                                @endif
                                <span>{{ $tab->getLabel() }}</span>

                                <!-- Active indicator -->
                                <div
                                        x-show="activeTab === '{{ $tab->getId() }}'"
                                        class="absolute left-0 w-1 inset-y-0 my-1 bg-primary-600 dark:bg-primary-500 rounded-r-full"
                                        style="display: none;"
                                        x-transition:enter="transition ease-in-out duration-200"
                                        x-transition:enter-start="opacity-0 transform -translate-x-1"
                                        x-transition:enter-end="opacity-100 transform translate-x-0"
                                ></div>
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 min-w-0">
            @foreach ($getChildComponentContainer()->getComponents() as $tab)
                <div
                        x-show="activeTab === '{{ $tab->getId() }}'"
                        x-transition:enter="transition ease-in-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        style="display: none;"
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6"
                >
                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700 pb-4 flex justify-between items-center lg:hidden">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white flex items-center gap-3">
                            @if($tab->getIcon())
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-800/30 text-primary-600 dark:text-primary-400">
                                    <x-dynamic-component :component="$tab->getIcon()" class="h-5 w-5" />
                                </span>
                            @endif
                            {{ $tab->getLabel() }}
                        </h2>

                        <!-- Previous/Next buttons for mobile -->
                        <div class="flex gap-2">
                            <button
                                    type="button"
                                    x-on:click="goToPrevTab()"
                                    x-bind:disabled="!hasPrevTab()"
                                    class="p-1 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition"
                                    aria-label="Previous tab">
                            
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button
                                    type="button"
                                    x-on:click="goToNextTab()"
                                    x-bind:disabled="!hasNextTab()"
                                    class="p-1 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition"
                                    aria-label="Next tab"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        {{ $tab }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
