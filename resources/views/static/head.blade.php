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
	<meta name="description" content="{{ $desc ?? 'Matteo Salonia\'s OpenAlias WebUI' }}">

	<!-- OpenGraph (Facebook) tags -->
	<meta property="og:title"        content="{{ $title ?? 'OpenAlias WebUI'}}">
	<meta property="og:description"  content="{{ $desc ?? 'Matteo Salonia\'s OpenAlias WebUI' }}">
	<meta property="og:site_name"    content="{{ Config::get('app.sitename') }}">
	<meta property="og:image"        content="/banner.png">
	<meta property="og:image:alt"    content="{{ Config::get('app.name') }}">
	<meta property="og:image:height" content="600">
	<meta property="og:image:width"  content="1200">
	<meta property="og:type"         content="website">
	<meta property="og:url"          content="{{ $url ?? Url::getURL() }}">

	<!-- Twitter/X tags -->
	<meta name="twitter:card"            content="summary_large_image">
	<meta property="twitter:title"       content="{{ $title ?? 'OpenAlias WebUI'}}">
	<meta property="twitter:description" content="{{ $desc ?? 'Matteo Salonia\'s OpenAlias WebUI' }}">
	<meta property="twitter:image"       content="/banner.png">
	<meta property="twitter:url"         content="{{ $url ?? Url::getURL() }}">
	@endif

	<!-- Favicon -->
	<link rel="shortcut icon" href="/favicon.png">

	<!-- CSS & Fonts -->
	@vite([
		'resources/css/cirrus.min.css',
		'resources/css/fonts/fonts.css',
		'resources/css/overrides.css',
	])

	<!-- JS -->
	@vite(['resources/js/main.js'])
</head>
