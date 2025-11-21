<x-app-layout>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">

                <h2 class="h4 mb-3 fw-bold">
                    {{ __('Dashboard') }}
                </h2>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <livewire:manage-projects /> 
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>