<div id="preloader">
    <img src="{{ asset(template(true).'img/preloader/game.png') }}" alt="preloader-img">
</div>
<style>
    .hidden {
        display: none !important;
    }
</style>
<script>
    window.addEventListener("load", function () {
        document.getElementById("preloader").classList.add("hidden");
    });
</script>
