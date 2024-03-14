<script type="text/javascript">
	$(function () {
		$('.datetimepicker').datetimepicker({
			format: 'YYYY-MM-DD'
		});
	});

	function lihatHasil(id) {
		var pisah = id.split("_");
		var rumus_id = pisah[0];
		var random_key = pisah[1];

		$.getJSON('<?= base_url() ?>/master/rumus_multiple/getParameterRumus', {
			id_parameter: rumus_id
		}, function(json) {
			var rumus = '';
			var urut = ''
			$.each(json, function(index, val) {
				var urut = val.rumus_detail_urut
				if (val.rumus_jenis == 'I') rumus += '(' + $('#logsheet_detail_detail_rumus_isi_' + val.detail_parameter_rumus_id + '_' + random_key).val() + ')';
				else if (val.rumus_jenis == 'A') rumus += '(' + val.rumus_detail_input + ')';
				else rumus += val.rumus_detail_input;
			});
			var hasil = (math.evaluate(rumus));
			$('#' + id).val(hasil.toFixed(2));
		});
	}
</script>