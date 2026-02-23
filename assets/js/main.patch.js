/**
 * main.patch.js
 * Letakkan SETELAH main.js di footer.php
 *
 * Tujuan: Menonaktifkan Simple DataTables bawaan NiceAdmin
 * agar tidak konflik dengan jQuery DataTables yang kita pakai.
 *
 * Cara pasang di footer.php (tambah setelah main.js):
 *   <script src="<?= base_url('assets/js/main.patch.js') ?>"></script>
 *
 * Simpan file ini di: assets/js/main.patch.js
 */

// Override Simple DataTables agar tidak error saat elemen .datatable tidak ada
(function () {
	"use strict";

	// Cegah error jika SimpleDatatables tidak ada
	if (typeof simpleDatatables === "undefined") return;

	// Re-override agar selector .datatable tidak crash di halaman kita
	document.addEventListener("DOMContentLoaded", function () {
		var tables = document.querySelectorAll(".simple-datatable");
		tables.forEach(function (el) {
			try {
				new simpleDatatables.DataTable(el);
			} catch (e) {
				// silent
			}
		});
	});
})();
