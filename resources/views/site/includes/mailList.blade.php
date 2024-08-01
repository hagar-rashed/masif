<div class="form-footer">
    <form action="{{ route('site.mail') }}" method="POST">
        @csrf
        <h2>{{ __('models.subscribe') }} </h2>
        <div class="input-form-footer">
            <input type="email" name="email" placeholder="{{ __('models.email') }}" class="form-control">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <button> <i class="fas fa-long-arrow-alt-left"></i> </button>
        </div>
    </form>
</div>
