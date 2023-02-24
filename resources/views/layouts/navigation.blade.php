<nav x-data="{ open: false }" class="bg-[#212121] border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="min-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 py-4">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center text-2xl lg:text-3xl text-[#7B7C7C]">
                    <a href="route('dashboard') "><h1>MUSICIAN<span class="text-[#F26D5C]">SUITE</span>RVA</h1></a>
                </div>
            </div>
            <!-- Navigation Links -->
            <div class="hidden lg:flex lg:items-center lg:space-x-6">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('DASHBOARD') }}
                </x-nav-link>
                <x-nav-link :href="route('musician-finder.dashboard')" :active="request()->routeIs('musician-finder.dashboard')">
                    {{ __('MUSICIAN FINDER') }}
                </x-nav-link>
                <x-nav-link href="https://www.classicalrevolutionrva.com">
                    {{ __('BACK TO CRRVA') }}
                </x-nav-link>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="{{ request()->routeIs('profile.edit') ? 'text-[#212121] bg-white' : 'text-white bg-transparent' }} inline-flex items-center px-3 py-3 border-2 border-white text-sm leading-4 font-medium rounded-full hover:text-[#212121] hover:bg-white focus:text-[#212121] focus:bg-white transition ease-in-out duration-150">
                            <div>{{ strtoupper(Auth::user()->name) }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                            {{ __('PROFILE') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('LOG OUT') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <div class="pt-2 px-2 sm:px-4 pb-3 border-t-2 border-white space-y-1">
             <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('DASHBOARD') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('musician-finder.dashboard')" :active="request()->routeIs('musician-finder.dashboard')">
                {{ __('MUSICIAN FINDER') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="https://www.classicalrevolutionrva.com">
                {{ __('BACK TO CRRVA') }}
            </x-responsive-nav-link>
            <div x-data="{settings: false}" class="block w-full pl-[0.6rem] pr-4 py-1 text-left">
                <div @click="settings=!settings" class="flex items-center justify-start text-left font-medium text-sm text-white {{ request()->routeIs('profile.edit') ? 'opacity-100' : 'opacity-80' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                    {{ strtoupper(Auth::user()->name) }}
                </div>
                <div x-show="settings" class="mt-3 ml-4 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
