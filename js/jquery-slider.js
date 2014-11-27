
var counter = 0, // to keep track of current slide
$items = $('.diy-slideshow figure'), // a collection of all of the slides, caching for performance
numItems = $items.length; // total number of slides


/** this function is what cycles the slides,
showing the next or previous slide and hiding all the others **/
var showCurrent = function(){
// calculates the actual index of the element to show
var itemToShow = Math.abs(counter%numItems);
// remove .show from whichever element currently has it
$items.removeClass('show');
// add .show only to the current slide
$items.eq(itemToShow).addClass('show');
};

// add click events to prev &amp; next buttons
$('.next').on('click', function(){
counter++;
showCurrent();
});
$('.prev').on('click', function(){
counter--;
showCurrent();
});

$(document).ready(function(){

var counter = 0,
$items = $('.diy-slideshow figure'),
numItems = $items.length;

var showCurrent = function(){
var itemToShow = Math.abs(counter%numItems);
$items.removeClass('show');
$items.eq(itemToShow).addClass('show');
};

$('.next').on('click', function(){
counter++;
showCurrent();
});

$('.prev').on('click', function(){
counter--;
showCurrent();
});

});

if('ontouchstart' in window){
$(".diy-slideshow").swipe({
swipeLeft:function() {
counter++;
showCurrent();
},
swipeRight:function() {
counter--;
showCurrent();
}
});
}
