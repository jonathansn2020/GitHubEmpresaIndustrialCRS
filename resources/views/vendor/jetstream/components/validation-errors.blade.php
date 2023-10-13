@if ($errors->any())
<div {{ $attributes }}>
    <div class="bg-red-100 text-red-700 p-4" role="alert">
        <p class="font-bold">Datos incorrectos!</p>
        @foreach ($errors->all() as $error)
        <span>{{ $error }}</span>
        @endforeach
    </div>
</div>
@endif