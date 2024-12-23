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
        🇬🇧 If you're seeing this error, you have entered an invalid input.
        Are you sure you entered a valid domain name?
        <br>
        If this error persists, and you are certain you have entered
        a valid input, please contact the administrator at the link below.
    </p>

    <p class="lead mt-0">
        🇮🇹 Se vedi questo messaggio di errore, hai inserito un input invalido.
        Sei sicuro di aver inserito un nome di dominio valido?
        <br>
        Se questo errore persiste, e sei sicuro di aver inserito
        un input valido, contatta l'amministratore al link qui sotto.
    </p>

    <a class="bg-blue-700 text-white u-round-xs px-2 py-1 font-bold text-lg" href="https://salonia.it/contact">
        <strong>Admin contact/Contatta l'amministratore</strong>
    </a>

    <div class="divider mx-10"></div>

    @include('static/home')
</x-card-error>

@include('static/footer')
</body>
</html>
