//ナビ
$(function() {
	$('.dropdown-btn').hover(
	  function() {
		$(this).children('.dropdown').addClass('open');
	  }, function() {
		$(this).children('.dropdown').removeClass('open');
	  }
	);
	 
	// レスポンシブナビ
	$('.nav-button-wrap').on('click', function() {
	  if ($(this).hasClass('active')) {
		$(this).removeClass('active');
		$('.globalnav').addClass('close');
		$('.globalnav-wrap').removeClass('open');
	  } else {
		$(this).addClass('active');
		$('.globalnav').removeClass('close');
		$('.globalnav-wrap , body').addClass('open');
	  }
	});
	
	//スタイドショー
	  let imgs = $(".slideshow > li");
	  let imgLen = imgs.length;
	  let count = 0;
	  function changeImg(){
		count = (count + 1) % imgLen;
		imgs.removeClass("showSlide").eq(count).addClass("showSlide");
	  }
	  setInterval(changeImg, 4000);


	  $('#image').on('change', function (e) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$("#preview").attr('src', e.target.result);
		}
		reader.readAsDataURL(e.target.files[0]);
	});
	  });
