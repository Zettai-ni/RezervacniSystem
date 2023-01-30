<script>
    var isScrolling = false;
    var newScroll = 0;

    function scrollDiv() {
        if (!isScrolling) {
            var div = document.querySelector('.filmy');
            newScroll = newScroll + 236;
            if (newScroll >= div.scrollWidth) {
                newScroll = 0;
            }
            div.scrollTo({
                left: newScroll,
                behavior: 'smooth'
            });
            console.log(div.scrollWidth);
            console.log(newScroll);
        }
    }
    document.querySelector('.filmy').addEventListener('mousedown', function() {
        isScrolling = true;
    });
    document.addEventListener('mouseup', function() {
        isScrolling = false;
    });
    setInterval(scrollDiv, 3000);
</script>