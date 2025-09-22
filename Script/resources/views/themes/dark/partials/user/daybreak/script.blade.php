<script src="{{ asset(template(true) . '/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{ asset(template(true) . 'js/bootstrap.bundle.min.js')}}"></script>
@stack('js-lib')
<script src="{{ asset(template(true) . 'js/select2.min.js')}}"></script>
<script src="{{ asset(template(true) . 'js/owl.carousel.min.js')}}"></script>
<script src="{{ asset(template(true) . 'js/jquery-ui.min.js')}}"></script>
<script src="{{ asset(template(true) . 'js/swiper-bundle.min.js')}}"></script>

<script src="{{ asset('assets/themes/dark/user/'.getDash().'/js/dashboard.js')}}"></script>

<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>

@push('script')
    <script>
        'use strict';
        const searchInput = document.getElementById('search-input');
        const resultsContainer = document.getElementById('search-result');


        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.trim();
            if (searchTerm.length > 0) {
                axios.get('{{ route('navSearch') }}', {
                    params: { query: searchTerm }
                })
                    .then(response => {
                        $('.search-result').removeClass('d-none');
                        resultsContainer.innerHTML = '';
                        if (Array.isArray(response.data)) {
                            response.data.forEach(item => {
                                const resultItem = document.createElement('a');
                                resultItem.href = item.details_route;
                                resultItem.classList.add('search-item');

                                resultItem.innerHTML = `
                                <div class="img-area">
                                    <img src="${item.preview}" alt="${item.name}">
                                </div>
                                <div class="text-area">
                                    <div class="title">${item.name}</div>
                                    <div class="sub-title">${item.typeOf}</div>
                                </div>
                            `;

                                resultsContainer.appendChild(resultItem);
                            });
                        } else {
                            console.error('Expected an array but got:', response.data);
                            resultsContainer.innerHTML = '<div class="text-area p-3"><p class="mb-0">No results found.</p></div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                        resultsContainer.innerHTML = '<p>Error occurred while searching.</p>';
                    });
            } else {
                resultsContainer.innerHTML = '<div class="text-area p-3"><p class="mb-0">No results found.</p></div>';
            }
        });

        searchInput.addEventListener('focus', function () {
            if (searchInput.value.trim().length === 0) {
                $('.search-result').removeClass('d-none');
                resultsContainer.innerHTML = '<div class="text-area p-3"><p class="mb-0">Start typing to search...</p></div>';
            }
        });

        document.addEventListener('click', function (event) {
            const isClickInside = searchInput.contains(event.target) || resultsContainer.contains(event.target);
            if (!isClickInside) {
                $('.search-result').addClass('d-none');
            }
        });

        searchInput.addEventListener('blur', function () {
            if (searchInput.value.trim().length === 0) {
                resultsContainer.innerHTML = '';
            }
        });
    </script>

@endpush

@stack('script')
@stack('extra_scripts')
