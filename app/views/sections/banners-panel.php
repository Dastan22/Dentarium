<div id="panelBanners" class="container-fluid h-100 d-flex flex-column">
    <div class="container-fluid h-100">
        <div class="row h-75">
            <div id="desktopBannersContainer" class="col-8 h-100 d-flex flex-column">
                <h3 class="mb-4">Баннеры для комп. версии сайта</h3>
                <?php foreach ($this->data['banners']['desktop'] as $v): ?>
                    <div class="banner-item d-flex align-items-center mb-3" data-banner-id="<?= $v['id'] ?>">
                        <img src="/public/img/banners/<?= $v['image'] ?>" alt="banner-image" height="250px">
                        <div class="icon cursor-pointer ml-4" style="background-image: url(/public/img/cross-icon.png); width: 20px; height: 20px"></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="mobileBannersContainer" class="col h-100 d-flex flex-column">
                <h3 class="mb-4">Баннеры для моб. версии сайта</h3>
                <?php foreach ($this->data['banners']['mobile'] as $v): ?>
                    <div class="banner-item d-flex align-items-center mb-3" data-banner-id="<?= $v['id'] ?>">
                        <img src="/public/img/banners/<?= $v['image'] ?>" alt="banner-image" height="250px">
                        <div class="icon cursor-pointer ml-4" style="background-image: url(/public/img/cross-icon.png); width: 20px; height: 20px"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-8">
                <form class="d-flex flex-column">
                    <input type="file" class="mb-2" required>
                    <input type="text" class="px-3 py-2" name="bannerLink" placeholder="Ссылка на страницу" required>
                    <button class="user-select-none cursor-pointer py-3 mt-2 text-center">Добавить</button>
                </form>
            </div>
            <div class="col-4">
                <form class="d-flex flex-column">
                    <input type="file" class="mb-2" required>
                    <input type="text" class="px-3 py-2" name="bannerLink" placeholder="Ссылка на страницу" required>
                    <button class="user-select-none cursor-pointer py-3 mt-2 text-center">Добавить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#panelBanners form").submit(addBanner);

    function addBanner(e) {
        e.preventDefault();

        if($( this ).hasClass('not-allowed')) {
            return;
        }

        $( this ).addClass('not-allowed');

        let link = $( this ).find('input[name="bannerLink"]').val(),
            bannerImg = $( this ).find('input[type="file"]').prop('files')[0],
            formData = new FormData(),
            currentForm = $( this );

        if(link === undefined || link === '') {
            alert('Необходимо указать ссылку для баннера');
            $( this ).removeClass('not-allowed');
            return;
        }

        formData.append('operation', 'add');
        formData.append('link', link);
        formData.append('image', bannerImg);

        $.ajax({
            url: '/app/api/Banner.php',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'text',
            processData: false,
            contentType: false,
            success: function() {
                alert('Новый баннер успешно добавлен');
                location.reload();
            },
            error: function (error) {
                alert(error.responseText);
                currentForm.removeClass('not-allowed');
            }
        });
    }

    $("#panelBanners .banner-item div").click(deleteBanner);

    function deleteBanner() {
        if($( this ).hasClass('not-allowed')) {
            return;
        }

        $( this ).addClass('not-allowed');

        let bannerId = $( this ).parent().attr('data-banner-id'), currentBtn = $( this );

        if(bannerId === '' || bannerId === undefined) {
            alert('Не удалось определить айди баннера');
            $( this ).removeClass('not-allowed');
            return;
        }

        $.post('/app/api/Banner.php', {
            operation: 'delete',
            bannerId
        }).done(function () {
            alert('Баннер успешно удален');
            location.reload();
        }).fail(function (error) {
            alert(error.responseText);
            currentBtn.remove('not-allowed');
        });
    }
</script>