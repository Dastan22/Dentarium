<section id="regPopup" class="fixed-top w-100 h-100 hide">
    <div class="container-fluid h-100 p-0">
        <div class="col-auto h-100 ml-auto">

            <div class="d-flex align-items-center pt-4 mb-5">
                <h3 class="mr-auto mb-0" style="font-size: 1.6rem; font-weight: 600; color: #292929">Вход</h3>
                <span class="icon close-popup cursor-pointer" style="background-image: url(../../../public/img/cross-icon.png); width: 20px; height: 20px"></span>
            </div>

            <form id="authForm">
                <label class="w-100 mb-4">
                    <input type="text" name="authPhone" class="w-100" placeholder="Телефон">
                </label>
                <label class="w-100">
                    <input type="password" name="authPassword" class="w-100" placeholder="Пароль">
                </label>
                <div class="d-flex mt-3 mb-1">
                    <div class="checkbox-wrapper mr-auto cursor-pointer d-flex">
                        <div id="needToSaveCheckbox" class="checkbox d-flex justify-content-center align-items-center mr-2">
                            <div class="checkbox-inner"></div>
                        </div>
                        <span class="mb-0 user-select-none" style="font-size: 0.8rem; font-weight: 500; color: #211F20">Запомнить меня</span>
                    </div>
                    <a href="" class="user-select-none" style="font-size: 0.8rem; font-weight: 500; color: #211F20">Забыли пароль?</a>
                </div>

                <div class="checkbox-wrapper mr-auto cursor-pointer d-flex mb-4">
                    <div id="targetCheckbox" class="checkbox d-flex justify-content-center align-items-center mr-2">
                        <div class="checkbox-inner"></div>
                    </div>
                    <span class="mb-0 user-select-none" style="font-size: 0.8rem; font-weight: 500; color: #211F20">Войти как администратор</span>
                </div>

                <div class="alert alert-danger hide" style="font-size: 0.9rem"></div>
                <button type="submit" class="text-center w-100">Войти</button>
            </form>

            <div class="text-center user-select-none mt-5 my-4" style="font-size: 0.9rem; font-weight: 500; color: #211F20">Создать аккаунт</div>

            <form id="regForm" class="pb-4">
                <label class="w-100 mb-4">
                    <input type="text" name="regPhone" class="w-100" placeholder="Телефон">
                </label>
                <label class="w-100 mb-4">
                    <input type="password" name="regPassword" class="w-100" placeholder="Пароль">
                </label>
                <label class="w-100 mb-4">
                    <input type="password" name="regConfirmPassword" class="w-100" placeholder="Повторите пароль">
                </label>
                <div class="checkbox-wrapper mr-auto cursor-pointer d-flex mb-4">
                    <div class="checkbox d-flex justify-content-center align-items-center mr-2">
                        <div class="checkbox-inner"></div>
                    </div>
                    <span class="mb-0 user-select-none" style="font-size: 0.8rem; font-weight: 500; color: #211F20">Я соглашаюсь с условиями пользования</span>
                </div>
                <div class="alert alert-danger hide" style="font-size: 0.9rem"></div>
                <div class="alert alert-success hide" style="font-size: 0.9rem"></div>
                <button type="submit" class="text-center w-100">Зарегистрироваться</button>
            </form>

        </div>
    </div>
</section>

<script type="text/javascript">
    let customCheckbox = $("#regPopup .checkbox-wrapper");

    customCheckbox.click(function () {
        $( this ).find('.checkbox').toggleClass('active');
    });
</script>

<script type="text/javascript">
    $("#regPopup input[name='authPhone']").inputmask('+7 (999) 999 9999');
    $("#regPopup input[name='regPhone']").inputmask('+7 (999) 999 9999');
</script>