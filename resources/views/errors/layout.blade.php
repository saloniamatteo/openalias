@use('App\Helpers\Url')
@include('static/head', [
    "title" => "Error",
    "noseo" => 1,
])

<body>
@include('static/header')

<!-- Error card -->
<x-card-error>
    <x-tag-error>
        Error/Errore
    </x-tag-error>

    <p class="lead">
        🇬🇧 The page you're looking for does not exist, or may have been moved.
        <br>
        If this error persists please contact the administrator at the link below.
    </p>

    <p class="lead mt-0">
        🇮🇹 La pagina che stai cercando non esiste, o potrebbe essere stata spostata.
        <br>
        Se questo errore persiste contatta l'amministratore al link qui sotto.
    </p>

    <a class="bg-blue-700 text-white u-round-xs px-2 py-1 font-bold text-lg" href="https://salonia.it/contact">
        <strong>Admin contact</strong>
    </a>

    <div class="divider mx-10"></div>

    @include('static/home')
</x-card-error>

@include('static/footer')
</body>
</html>
