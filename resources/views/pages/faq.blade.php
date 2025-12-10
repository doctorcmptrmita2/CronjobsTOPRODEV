<x-public-layout>
    <div class="min-h-screen py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero -->
            <div class="text-center mb-12">
                <h1 class="text-4xl sm:text-5xl font-bold text-midnight-50 mb-4">
                    Frequently Asked <span class="text-gradient">Questions</span>
                </h1>
                <p class="text-xl text-midnight-400">
                    Everything you need to know about Cronjobs.to
                </p>
            </div>

            <!-- Search -->
            <div class="mb-12">
                <div class="relative max-w-xl mx-auto">
                    <input type="text" id="faq-search" 
                           class="input pl-12 text-lg" 
                           placeholder="Search questions...">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-midnight-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- FAQ Categories -->
            <div class="space-y-8" id="faq-container">
                @foreach($faqs as $category)
                    <div class="faq-category">
                        <h2 class="text-xl font-bold text-midnight-50 mb-4 flex items-center gap-3">
                            <span class="w-8 h-8 bg-accent-500/10 rounded-lg flex items-center justify-center">
                                @if($category['category'] === 'Getting Started')
                                    <svg class="w-4 h-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                @elseif($category['category'] === 'Scheduling')
                                    <svg class="w-4 h-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($category['category'] === 'Monitoring & Alerts')
                                    <svg class="w-4 h-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                @elseif($category['category'] === 'Security & Reliability')
                                    <svg class="w-4 h-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                @endif
                            </span>
                            {{ $category['category'] }}
                        </h2>

                        <div class="space-y-3">
                            @foreach($category['questions'] as $index => $qa)
                                <div class="faq-item card overflow-hidden" data-question="{{ strtolower($qa['q']) }}" data-answer="{{ strtolower($qa['a']) }}">
                                    <button type="button" 
                                            class="faq-toggle w-full p-5 text-left flex items-center justify-between gap-4 hover:bg-midnight-800/50 transition-colors"
                                            onclick="toggleFaq(this)">
                                        <span class="font-medium text-midnight-100">{{ $qa['q'] }}</span>
                                        <svg class="faq-icon w-5 h-5 text-midnight-500 flex-shrink-0 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="faq-answer hidden px-5 pb-5">
                                        <p class="text-midnight-400 leading-relaxed">{{ $qa['a'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Still Have Questions -->
            <div class="mt-16 card p-8 text-center bg-gradient-to-br from-midnight-900 via-midnight-900 to-accent-900/20">
                <div class="w-16 h-16 bg-accent-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-accent-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-midnight-50 mb-3">Still Have Questions?</h2>
                <p class="text-midnight-400 mb-6 max-w-md mx-auto">
                    Can't find what you're looking for? Our support team is here to help.
                </p>
                <a href="{{ route('contact') }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contact Support
                </a>
            </div>
        </div>
    </div>

    <script>
        function toggleFaq(button) {
            const item = button.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon');
            
            answer.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }

        // Search functionality
        document.getElementById('faq-search').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.faq-item');
            const categories = document.querySelectorAll('.faq-category');
            
            items.forEach(item => {
                const question = item.dataset.question;
                const answer = item.dataset.answer;
                const matches = question.includes(query) || answer.includes(query);
                item.style.display = matches ? 'block' : 'none';
            });

            // Hide empty categories
            categories.forEach(category => {
                const visibleItems = category.querySelectorAll('.faq-item[style="display: block"], .faq-item:not([style])');
                const hasVisible = Array.from(visibleItems).some(item => item.style.display !== 'none');
                category.style.display = hasVisible || query === '' ? 'block' : 'none';
            });
        });
    </script>
</x-public-layout>

