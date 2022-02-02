<section id="popularsSliderDesktop" class="d-none d-md-block">
    <div class="container-fluid px-4">
        <h3 class="user-select-none mb-3">Интересные товары на этой недели</h3>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($this->data['banners']['desktop'] as $v): ?>
                    <a href="<?= $v['link'] ?>" target="_blank" class="slider-item swiper-slide bg-cover" style="background-image: url(<?= '/public/img/banners/' . $v['image'] ?>)"></a>
                <?php endforeach; ?>
            </div>
            <div class="swiper-scrollbar mt-3"></div>
        </div>
    </div>
</section>


<script type="text/javascript">
    new Swiper('#popularsSliderDesktop .swiper-container', {
        slidesPerView: 'auto',
        spaceBetween: 10,
        scrollbar: {
            el: '#popularsSliderDesktop .swiper-scrollbar',
            hide: true
        }
    });
</script>