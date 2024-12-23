@use('App\Helpers\Url')
<!DOCTYPE html>
<html>
<head>
	<title>{{ $title ?? 'OpenAlias WebUI' }}</title>

	<!-- Optimize page loading -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- SEO (do not include if "noseo" is set) -->
	@if (!isset($noseo))
	<meta name="description"				content="{{ $desc ?? 'Matteo Salonia\'s OpenAlias WebUI' }}">
	<meta property="og:description"			content="{{ $desc ?? 'Matteo Salonia\'s OpenAlias WebUI' }}">
	<meta property="twitter:description"	content="{{ $desc ?? 'Matteo Salonia\'s OpenAlias WebUI' }}">
	<meta property="og:title"				content="{{ $title ?? 'OpenAlias WebUI'}}">
	<meta property="twitter:title"			content="{{ $title ?? 'OpenAlias WebUI' }}">
	<meta property="og:url"					content="{{ $url ?? Url::getURL() }}">
	<meta property="og:image"				content="/favicon.png">
	<meta property="twitter:image"			content="/favicon.png">
	@endif

	<!-- Favicon -->
	<link rel="shortcut icon" href="/favicon.png">

	<!-- CSS & Fonts -->
	@vite(['resources/css/cirrus.min.css', 'resources/css/fonts/fonts.css'])

	<!-- JS -->
	@vite(['resources/js/main.js'])

	<!-- Overrides -->
	<style>
	.card { box-shadow: none }
	code { padding: .2rem }
	td { word-break: break-all }
	th { vertical-align: middle!important }
	</style>
</head>
