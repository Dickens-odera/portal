@if(session('success'))
        <div class="alert alert-success text-center">
            {{session('success')}}
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
            </button>
        </div>
@endif

@if(session('error'))
        <div class="alert alert-danger text-center">
            {{session('error')}}
            <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
            </button>
        </div>
@endif
