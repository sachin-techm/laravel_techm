$('.nav-toggle').click(function() {
	$(this).toggleClass('active');
	$('.overlay').toggleClass('open');
});

$(document).ready(function(){
	$('.saf-partner').slick({
		speed: 600,
		slidesToShow: 3,
		slidesToScroll: 1,
		autoplay: true,
		dots:false,
		autoplaySpeed: 5000,
		centerMode:true,
		nextArrow: false,
		prevArrow: false,
		responsive: [{
			breakpoint: 1024,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1,
                  // centerMode: true,

              }

          }, {
          	breakpoint: 1024,
          	settings: {
          		slidesToShow: 1,
          		slidesToScroll: 1,
          		infinite: true,
          		autoplay: true,
          		autoplaySpeed: 6000,
          	}
          },  {
          	breakpoint: 480,
          	settings: {
          		slidesToShow: 1,
          		slidesToScroll: 1,
          		infinite: true,
          		autoplay: true,
          		autoplaySpeed: 6000,
          	}
          }]
      });
});

var targetDiv = $('.main-header');

$(window).scroll(function() {

	var windowpos = $(window).scrollTop();

	if( windowpos >= 50 ) {
		targetDiv.addClass('hide-nav');
	} else {
		targetDiv.removeClass('hide-nav');
	}

});

jQuery(document).ready(function(){
	jQuery(".drop-btn").click(function(){
		jQuery(".dropdowncstm").toggleClass("showdropdown");
	});
});

const slider = document.querySelector('.scroll-curators');
if(slider){
	
	let isDown = false;
	let startX;
	let scrollLeft;

	slider.addEventListener('mousedown', (e) => {
		let rect = slider.getBoundingClientRect();
		isDown = true;
		slider.classList.add('active');
	  // Get initial mouse position
	  startX = e.pageX - rect.left;
	  // Get initial scroll position in pixels from left
	  scrollLeft = slider.scrollLeft;
	  console.log(startX, scrollLeft);
	});

	slider.addEventListener('mouseleave', () => {
		isDown = false;
		slider.dataset.dragging = false;
		slider.classList.remove('active');
	});

	slider.addEventListener('mouseup', () => {
		isDown = false;
		slider.dataset.dragging = false;
		slider.classList.remove('active');
	});

	slider.addEventListener('mousemove', (e) => {
		if (!isDown) return;
		let rect = slider.getBoundingClientRect();
		e.preventDefault();
		slider.dataset.dragging = true;
	  // Get new mouse position
	  const x = e.pageX - rect.left;
	  // Get distance mouse has moved (new mouse position minus initial mouse position)
	  const walk = (x - startX);
	  // Update scroll position of slider from left (amount mouse has moved minus initial scroll position)
	  slider.scrollLeft = scrollLeft - walk;
	  console.log(x, walk, slider.scrollLeft);
	});
}
