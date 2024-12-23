<!-- Footer -->
<footer class="footer bg-black p-4 mt-0 u-center">
	<a href="https://salonia.it">
		<!-- Instead of including yet another image, include the same image
		     as the header, then we use CSS to invert the colors -->
		<img src="{{ Vite::asset('resources/img/salonia.png') }}"
		alt="Logo" loading="lazy"
		style="min-width: 180px; width: 14rem !important; filter: invert(1)">
	</a>

	<h4 class="title text-white mt-1 mb-1" style="padding-top: 0.15em !important">Infrastrutture Digitali</h4>
	<h6 class="font-bold text-white mb-0 w-100p">di <a class="text-blue-300" href="https://salonia.it/contact">Salonia Matteo</a></h6>
	<p class="text-sm text-white mt-2 mb-0 w-100p">&copy; 2020-<?= date("Y") ?></p>
</footer>
