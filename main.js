$(function() {
	//画像プレビュー
	  $('#image').on('change', function (e) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$("#preview").attr('src', e.target.result);
		}
		reader.readAsDataURL(e.target.files[0]);
	});

	//プロフ画像プレビュー
	$('#images').on('change', function (e) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$("#previews").attr('src', e.target.result);
		}
		reader.readAsDataURL(e.target.files[0]);
	});

	//削除アラート
	$('.delete').click(function(){
		if(!confirm('本当に削除しますか？')){
			
			return false;
		}
	});

	//退会アラート
	$('.cancel-the-membership').click(function(){
		if(!confirm('本当に退会しますか？')){
			
			return false;
		}
	});
});
