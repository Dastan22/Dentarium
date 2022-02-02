<section id="popularsSliderMobile" class="d-block d-md-none mt-4">
    <div class="container-fluid px-4">
        <h3 class="user-select-none">Интересные товары на этой недели</h3>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($this->data['banners']['mobile'] as $v): ?>
                    <a href="<?= $v['link'] ?>" target="_blank" class="slider-item swiper-slide bg-cover" style="background-image: url(<?= '/public/img/banners/' . $v['image'] ?>)"></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    new Swiper('#popularsSliderMobile .swiper-container', {
        slidesPerView: 'auto',
        spaceBetween: 20
    });
</script>